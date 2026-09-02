<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// CSRF Protection
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

$student_id = $_SESSION['user_id'];
$quiz_id = intval($_POST['quiz_id'] ?? 0);
$answers = $_POST['answers'] ?? []; // question_id => option_id

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Model object
$quizModel = new Quiz($conn);

// Verify quiz is active and student belongs to its batch
if (!$quizModel->isQuizActiveForStudent($quiz_id, $student_id)) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Check if already attempted
if ($quizModel->hasStudentAttempted($quiz_id, $student_id)) {
    header('Location: ' . BASE_URL . '/student/controller/results.php');
    exit;
}

// Fetch questions and correct answers
$quizData = $quizModel->getQuestionsAndCorrectAnswers($quiz_id);
$correct_answers = $quizData['correct_answers'];
$total_questions = count($quizData['question_ids']);

// Calculate obtained marks
$obtained_marks = 0;
foreach ($answers as $qid => $selected_option_id) {
    $qid = intval($qid);
    $selected_option_id = intval($selected_option_id);
    if (isset($correct_answers[$qid]) && $correct_answers[$qid] === $selected_option_id) {
        $obtained_marks++;
    }
}

$total_marks = $total_questions;
$percentage = ($total_marks > 0) ? round(($obtained_marks / $total_marks) * 100, 2) : 0;

// Insert attempt
$quizModel->insertQuizAttempt($quiz_id, $student_id, $obtained_marks, $total_marks, $percentage);

// Get quiz info for history
$quiz_info = $quizModel->getQuizInfoForHistory($quiz_id);
$quiz_title = $quiz_info['title'];
$teacher_id_for_quiz = $quiz_info['teacher_id'];
$passing_marks = $quiz_info['passing_marks'];

// Determine pass/fail
$status = ($percentage >= $passing_marks) ? 'pass' : 'fail';

// Get student name
$student_name = $quizModel->getStudentName($student_id);

// Insert permanent history
$quizModel->insertQuizAttemptHistory($teacher_id_for_quiz, $student_id, $student_name, $quiz_title, $percentage, $status);

// Redirect to results
header('Location: ' . BASE_URL . '/student/controller/results.php');
exit;