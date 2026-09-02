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

// Basic validation
if ($batch_id <= 0 || empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $_SESSION['attendance_error'] = 'Invalid batch or date.';
    header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
    exit;
}

// Model object
$attendanceModel = new Attendance($conn);

// Save attendance through model
$result = $attendanceModel->saveAttendance($batch_id, $date, $attendance_data, $teacher_id);

if ($result['success']) {
    $_SESSION['attendance_msg'] = $result['message'];
} else {
    $_SESSION['attendance_error'] = $result['message'];
}

header('Location: ' . BASE_URL . '/teacher/controller/attendance.php');
exit;