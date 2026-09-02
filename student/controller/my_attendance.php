<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['student']);

$student_id = $_SESSION['user_id'];

// Model object
$attendanceModel = new Attendance($conn);

// Fetch attendance records
$attendance_records = $attendanceModel->getStudentAttendance($student_id);

// Summary counts
$summary = $attendanceModel->getAttendanceSummary($attendance_records);

$total_records = count($attendance_records);

// Attendance percentage (present + late ko present maan lo)
$present_like_count = $summary['present'] + $summary['late'];
$attendance_percentage = ($total_records > 0) ? round(($present_like_count / $total_records) * 100, 2) : 0;

include BASE_PATH . 'student/view/my_attendance.php';
?>