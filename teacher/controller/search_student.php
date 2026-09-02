<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$searched_student = null;
$error = '';

// Model object
$studentModel = new Student($conn);

// Agar GET mein student_id hai to search karo
if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_term = trim($_GET['student_id']);

    // Model se search karo
    $searched_student = $studentModel->searchStudentWithProgress($search_term, $teacher_id);

    if (!$searched_student) {
        $error = 'No student found with this ID under your supervision.';
    }
}

// View load karo
include BASE_PATH . 'teacher/view/search_student.php';
?>