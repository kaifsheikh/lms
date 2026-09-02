<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

// Sirf POST requests allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// CSRF Protection
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

// Student ID validate karo
$student_db_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);

if (!$student_db_id || $student_db_id <= 0) {
    $_SESSION['student_error'] = 'Invalid student ID.';
    header('Location: ' . BASE_URL . '/admin/controller/student/manage.php');
    exit;
}

// Model object banao
$studentModel = new Student($conn);

// 1. Student ki file names fetch karo (taake delete kar saken)
$files = $studentModel->getStudentFiles($student_db_id);

// 2. Database se student record delete karo
if (!$studentModel->deleteStudent($student_db_id)) {
    $_SESSION['student_error'] = 'Failed to delete student.';
    header('Location: ' . BASE_URL . '/admin/controller/student/manage.php');
    exit;
}

// 3. Uploaded files delete karo (agar exist karti hain)
$upload_dir = BASE_PATH . 'assets/uploads/students/';

if (!empty($files['student_pic'])) {
    $student_file = basename($files['student_pic']);
    $student_path = $upload_dir . $student_file;
    if (is_file($student_path)) {
        unlink($student_path);
    }
}

if (!empty($files['cnic_pic'])) {
    $cnic_file = basename($files['cnic_pic']);
    $cnic_path = $upload_dir . $cnic_file;
    if (is_file($cnic_path)) {
        unlink($cnic_path);
    }
}

// Success message
$_SESSION['student_msg'] = 'Student deleted successfully.';

// Redirect
header('Location: ' . BASE_URL . '/admin/controller/student/manage.php');
exit;