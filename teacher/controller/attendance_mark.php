<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$attendance_already_marked = false;
$batch = null;

// GET parameters
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
$date = $_GET['date'] ?? date('Y-m-d');

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

if ($batch_id <= 0) {
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}

// Verify batch belongs to teacher and is approved
$stmt = $conn->prepare("
    SELECT id, batch_name
    FROM batches
    WHERE id = ? AND teacher_id = ? AND status = 'approved'
");
$stmt->bind_param("ii", $batch_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $batch = $row;
} else {
    $error = 'Batch not found or you do not have permission.';
    $stmt->close();
    include BASE_PATH . 'teacher/view/attendance_mark.php';
    exit;
}
$stmt->close();

// Check if attendance already exists for this batch and date
$stmt = $conn->prepare("SELECT id FROM attendance WHERE batch_id = ? AND date = ?");
$stmt->bind_param("is", $batch_id, $date);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $attendance_already_marked = true;
    $error = 'Attendance already marked for this date.';
} else {
    // Fetch students in this batch
    $students = [];
    $stmt2 = $conn->prepare("
        SELECT s.id, s.student_id, s.full_name
        FROM students s
        INNER JOIN batch_students bs ON s.id = bs.student_id
        WHERE bs.batch_id = ?
        ORDER BY s.full_name ASC
    ");
    $stmt2->bind_param("i", $batch_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $students[] = $row2;
    }
    $stmt2->close();
}
$stmt->close();

// Pass data to view
include BASE_PATH . 'teacher/view/attendance_mark.php';
?>