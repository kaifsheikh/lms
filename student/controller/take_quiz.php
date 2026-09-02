<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$error = '';

// Quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Model object
$quizModel = new Quiz($conn);

// Fetch quiz details (verify active and batch membership)
$quiz = $quizModel->getQuizForStudent($quiz_id, $student_id);

if (!$quiz) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Check if already attempted
if ($quizModel->hasStudentAttempted($quiz_id, $student_id)) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Fetch questions and options
$questions = $quizModel->getQuestionsWithOptions($quiz_id);

// Timer in seconds
$timer_seconds = $quiz['timer'] * 60;

// Load view
include BASE_PATH . 'student/view/take_quiz.php';
?>