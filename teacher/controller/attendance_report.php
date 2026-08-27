<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$report_data = [];
$selected_batch = null;
$selected_date = '';

// GET parameters
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
$date = $_GET['date'] ?? date('Y-m-d');

// Validate date
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

// Fetch teacher's approved batches for dropdown
$batches = [];
$stmt = $conn->prepare("SELECT id, batch_name FROM batches WHERE teacher_id = ? AND status = 'approved' ORDER BY batch_name");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
$stmt->close();

// If batch selected, fetch its attendance for that date
if ($batch_id > 0) {
    // Verify batch belongs to teacher
    $stmt = $conn->prepare("SELECT id, batch_name FROM batches WHERE id = ? AND teacher_id = ? AND status = 'approved'");
    $stmt->bind_param("ii", $batch_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selected_batch = $row;
    } else {
        $error = 'Batch not found or permission denied.';
        $stmt->close();
        $batch_id = 0;
    }
    $stmt->close();

    if ($batch_id > 0) {
        // Fetch attendance records for that batch and date, joined with student info
        $stmt = $conn->prepare("
            SELECT a.id, a.status, s.student_id, s.full_name
            FROM attendance a
            INNER JOIN students s ON a.student_id = s.id
            WHERE a.batch_id = ? AND a.date = ?
            ORDER BY s.full_name ASC
        ");
        $stmt->bind_param("is", $batch_id, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $report_data[] = $row;
        }
        $stmt->close();
    }
}

$selected_date = $date;

include BASE_PATH . 'teacher/view/attendance_report.php';
?>