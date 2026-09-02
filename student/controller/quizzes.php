<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$error = '';

// Model object
$quizModel = new Quiz($conn);

// Active quizzes fetch karo
$quizzes = $quizModel->getActiveQuizzesForStudent($student_id);

// View load karo
include BASE_PATH . 'student/view/quizzes.php';
?>