<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/Course.php';

requireRole(['admin']);

$message = '';
$error = '';

$courseModel = new Course($conn);

// Flash messages
if (isset($_SESSION['course_msg'])) {
    $message = $_SESSION['course_msg'];
    unset($_SESSION['course_msg']);
}
if (isset($_SESSION['course_error'])) {
    $error = $_SESSION['course_error'];
    unset($_SESSION['course_error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $data = [
        'course_name' => trim($_POST['course_name'] ?? ''),
        'duration' => intval($_POST['duration'] ?? 0),
        'admission_fee' => floatval($_POST['admission_fee'] ?? 0),
        'total_price' => floatval($_POST['total_price'] ?? 0),
        'skill_level' => trim($_POST['skill_level'] ?? ''),
        'schedule' => trim($_POST['schedule'] ?? ''),
        'class_hours' => trim($_POST['class_hours'] ?? ''),
        'outline' => trim($_POST['outline'] ?? '')
    ];

    if (empty($data['course_name']) || $data['duration'] <= 0 || $data['admission_fee'] <= 0 || $data['total_price'] <= 0 || empty($data['skill_level']) || empty($data['schedule']) || empty($data['class_hours'])) {
        $error = 'تمام فیلڈز درکار ہیں اور درست ہونے چاہئیں۔';
    } else {
        if ($courseModel->createCourse($data)) {
            $_SESSION['course_msg'] = 'Course Added Successfully';
            header('Location: ' . BASE_URL . '/admin/controller/course_management.php');
            exit;
        } else {
            $error = 'Course not Added';
        }
    }
}

include BASE_PATH . 'admin/view/course_management.php';
?>