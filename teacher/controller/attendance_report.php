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

// Model object
$attendanceModel = new Attendance($conn);

// Fetch approved batches for dropdown
$batches = $attendanceModel->getApprovedBatchesForTeacher($teacher_id);

// If batch selected
if ($batch_id > 0) {
    // Verify batch ownership and get batch name
    $selected_batch = $attendanceModel->getBatchByIdAndTeacher($batch_id, $teacher_id);
    if (!$selected_batch) {
        $error = 'Batch not found or permission denied.';
        $batch_id = 0;
    } else {
        // Fetch attendance report
        $report_data = $attendanceModel->getAttendanceReportByBatchAndDate($batch_id, $date);
    }
}

$selected_date = $date;

include BASE_PATH . 'teacher/view/attendance_report.php';
?>