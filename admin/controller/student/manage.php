<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';

// Flash messages
if (isset($_SESSION['student_msg'])) {
    $message = $_SESSION['student_msg'];
    unset($_SESSION['student_msg']);
}
if (isset($_SESSION['student_error'])) {
    $error = $_SESSION['student_error'];
    unset($_SESSION['student_error']);
}

// Model object
$studentModel = new Student($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'assign_teacher') {
        $student_id = intval($_POST['student_id'] ?? 0);
        $teacher_id = intval($_POST['teacher_id'] ?? 0);

        if ($student_id <= 0 || $teacher_id <= 0) {
            $error = 'Invalid selection.';
        } else {
            // Sirf teacher assign, batch remove
            $result = $batchModel->assignStudentToTeacherAndBatch($student_id, $teacher_id, null);
            if ($result['success']) {
                $message = $result['message'];
            } else {
                $error = $result['message'];
            }
        }
    } elseif ($action === 'update_status') {
        $student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
        $new_status = $_POST['status'] ?? '';

        if (!$student_id || $student_id <= 0) {
            $error = 'Invalid student ID.';
        } elseif (!in_array($new_status, ['pending', 'process', 'active'], true)) {
            $error = 'Invalid status selected.';
        } else {
            $result = $studentModel->updateStatus($student_id, $new_status);
            if ($result['success']) {
                if ($result['affected'] > 0) {
                    $message = 'Student status updated to ' . $new_status . '.';
                } else {
                    $error = 'Student not found or status is already the same.';
                }
            } else {
                $error = 'Failed to update student status.';
            }
        }
    }
}

// Fetch students with teacher name
$students = $studentModel->getStudentsWithTeacher();

// Fetch approved teachers
$teachers = $studentModel->getApprovedTeachers();

// Search by student ID
$searched_student = null;
$search_error = '';
if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_term = trim($_GET['student_id']);
    $searched_student = $studentModel->getStudentByStudentId($search_term);
    if (!$searched_student) {
        $search_error = 'No student found with that Student ID.';
    }
}

include BASE_PATH . 'admin/view/student/manage.php';
?>