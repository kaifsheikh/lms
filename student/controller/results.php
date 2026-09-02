<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];

// Model object
$quizModel = new Quiz($conn);

// Student ke results fetch karo
$results = $quizModel->getStudentResults($student_id);

include BASE_PATH . 'student/view/results.php';
?>