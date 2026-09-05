<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$report_data = [];
$monthly_data = [];
$selected_batch = null;
$selected_date = '';
$selected_month = date('Y-m');

// GET parameters
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
$date = $_GET['date'] ?? date('Y-m-d');
$month = $_GET['month'] ?? $selected_month;

// Validate date
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

// Validate month format
if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
    $month = date('Y-m');
}

$attendanceModel = new Attendance($conn);
$batches = $attendanceModel->getApprovedBatchesForTeacher($teacher_id);

if ($batch_id > 0) {
    $selected_batch = $attendanceModel->getBatchByIdAndTeacher($batch_id, $teacher_id);
    if (!$selected_batch) {
        $error = 'Batch not found or permission denied.';
        $batch_id = 0;
    } else {
        $report_data = $attendanceModel->getAttendanceReportByBatchAndDate($batch_id, $date);
        $monthly_data = $attendanceModel->getMonthlyAttendanceReport($batch_id, $month);
    }
}

$selected_date = $date;

include BASE_PATH . 'teacher/view/attendance_report.php';