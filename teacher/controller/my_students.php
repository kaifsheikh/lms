<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

// Sirf teacher access
requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// Model object
$studentModel = new Student($conn);

// Unassigned students with details fetch karo
$students = $studentModel->getUnassignedStudentsWithDetailsForTeacher($teacher_id);

include BASE_PATH . 'teacher/view/my_students.php';
?>