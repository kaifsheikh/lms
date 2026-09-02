<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// Model object
$studentModel = new Student($conn);

// Fetch all students for this teacher (with course end date)
$students = $studentModel->getStudentsForTeacher($teacher_id);

include BASE_PATH . 'teacher/view/all_students.php';
?>