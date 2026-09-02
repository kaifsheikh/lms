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

// Model object
$attendanceModel = new Attendance($conn);

// Verify batch and get batch info
$batch = $attendanceModel->getApprovedBatchForTeacher($batch_id, $teacher_id);

if (!$batch) {
    $error = 'Batch not found or you do not have permission.';
    include BASE_PATH . 'teacher/view/attendance_mark.php';
    exit;
}

// Check if attendance already marked
if ($attendanceModel->isAttendanceMarked($batch_id, $date)) {
    $attendance_already_marked = true;
    $error = 'Attendance already marked for this date.';
} else {
    // Fetch students in this batch
    $students = $attendanceModel->getStudentsByBatch($batch_id);
}

// Load view
include BASE_PATH . 'teacher/view/attendance_mark.php';
?>