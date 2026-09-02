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

// POST actions (edit/delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'update_course') {
        $course_id = intval($_POST['course_id'] ?? 0);
        $data = [
            'course_name' => trim($_POST['course_name'] ?? ''),
            'duration' => intval($_POST['duration'] ?? 0),
            'admission_fee' => floatval($_POST['admission_fee'] ?? 0),
            'total_price' => floatval($_POST['total_price'] ?? 0),
            'skill_level' => trim($_POST['skill_level'] ?? ''),
            'schedule' => trim($_POST['schedule'] ?? ''),
            'class_hours' => trim($_POST['class_hours'] ?? '')
        ];

        if ($course_id <= 0 || empty($data['course_name']) || $data['duration'] <= 0 || $data['admission_fee'] <= 0 || $data['total_price'] <= 0 || empty($data['skill_level']) || empty($data['schedule']) || empty($data['class_hours'])) {
            $_SESSION['course_error'] = 'تمام فیلڈز درست بھریں۔';
        } else {
            if ($courseModel->updateCourse($course_id, $data)) {
                $_SESSION['course_msg'] = 'کورس اپ ڈیٹ ہو گیا۔';
            } else {
                $_SESSION['course_error'] = 'اپ ڈیٹ میں ناکامی۔';
            }
        }
        header('Location: ' . BASE_URL . '/admin/controller/courses_list.php');
        exit;

    } elseif ($action === 'delete_course') {
        $course_id = intval($_POST['course_id'] ?? 0);
        if ($course_id <= 0) {
            $_SESSION['course_error'] = 'غلط کورس ID۔';
        } else {
            if ($courseModel->deleteCourse($course_id)) {
                $_SESSION['course_msg'] = 'کورس ڈیلیٹ ہو گیا۔';
            } else {
                $_SESSION['course_error'] = 'ڈیلیٹ میں ناکامی۔';
            }
        }
        header('Location: ' . BASE_URL . '/admin/controller/courses_list.php');
        exit;
    }
}

// تمام کورسز حاصل کریں
$courses = $courseModel->getAllCourses();

include BASE_PATH . 'admin/view/courses_list.php';
?>