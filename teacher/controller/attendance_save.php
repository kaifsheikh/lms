<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}

// CSRF Protection
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

$teacher_id = $_SESSION['user_id'];
$batch_id = intval($_POST['batch_id'] ?? 0);
$date = $_POST['date'] ?? '';
$attendance_data = $_POST['attendance'] ?? [];

// Validate
if ($batch_id <= 0 || empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $_SESSION['attendance_error'] = 'Invalid batch or date.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}

// Verify batch belongs to teacher and is approved
$stmt = $conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ? AND status = 'approved'");
$stmt->bind_param("ii", $batch_id, $teacher_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $stmt->close();
    $_SESSION['attendance_error'] = 'Batch not found or permission denied.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}
$stmt->close();

// ❗ Check if attendance already exists for this batch and date
$check_stmt = $conn->prepare("SELECT id FROM attendance WHERE batch_id = ? AND date = ?");
$check_stmt->bind_param("is", $batch_id, $date);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    $check_stmt->close();
    $_SESSION['attendance_error'] = 'Attendance already marked for this date.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}
$check_stmt->close();

// Allowed statuses
$allowed_statuses = ['present', 'absent', 'late', 'leave'];

// Transaction start
$conn->begin_transaction();

try {
    // Simple INSERT (no ON DUPLICATE KEY UPDATE)
    $insert_stmt = $conn->prepare("INSERT INTO attendance (batch_id, student_id, date, status, marked_by) VALUES (?, ?, ?, ?, ?)");

    if (!$insert_stmt) {
        throw new Exception('Database error.');
    }

    foreach ($attendance_data as $student_id => $status) {
        $student_id = intval($student_id);
        if ($student_id <= 0 || !in_array($status, $allowed_statuses, true)) {
            continue; // Ignore invalid entries
        }

        // Verify student belongs to this batch
        $student_check = $conn->prepare("SELECT id FROM batch_students WHERE batch_id = ? AND student_id = ?");
        $student_check->bind_param("ii", $batch_id, $student_id);
        $student_check->execute();
        $student_check->store_result();
        if ($student_check->num_rows === 0) {
            $student_check->close();
            continue; // Student not in this batch, skip
        }
        $student_check->close();

        // Bind and execute insert
        $insert_stmt->bind_param("iissi", $batch_id, $student_id, $date, $status, $teacher_id);
        if (!$insert_stmt->execute()) {
            throw new Exception('Failed to save attendance for student ID ' . $student_id);
        }
    }

    $insert_stmt->close();
    $conn->commit();

    $_SESSION['attendance_msg'] = 'Attendance saved successfully.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;

} catch (Throwable $e) {
    $conn->rollback();
    $_SESSION['attendance_error'] = 'Failed to save attendance. Please try again.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}
?>