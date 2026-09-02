<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/teacher/controller/quiz_management.php');
    exit;
}

// Model object
$quizModel = new Quiz($conn);

// Fetch quiz details (with batch name)
$quiz = $quizModel->getQuizWithBatchForTeacher($quiz_id, $teacher_id);

if (!$quiz) {
    header('Location: ' . BASE_URL . '/teacher/controller/quiz_management.php');
    exit;
}

// =====================================================
// HANDLE POST: ADD QUESTION
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $question_text = trim($_POST['question_text'] ?? '');
    $options = $_POST['options'] ?? [];
    $correct_index = intval($_POST['correct_option'] ?? -1);

    // Validate
    if (empty($question_text)) {
        $error = 'Question text is required.';
    } elseif (count($options) < 2) {
        $error = 'At least two options are required.';
    } elseif ($correct_index < 0 || $correct_index >= count($options)) {
        $error = 'Please select a correct answer.';
    } else {
        // Add question via model
        if ($quizModel->addQuestion($quiz_id, $question_text, $options, $correct_index)) {
            $success = 'Question added successfully!';
        } else {
            $error = 'Failed to add question.';
        }
    }
}

// =====================================================
// FETCH EXISTING QUESTIONS FOR THIS QUIZ
// =====================================================
$questions = $quizModel->getQuestionsWithOptions($quiz_id);

// =====================================================
// LOAD VIEW
// =====================================================
include BASE_PATH . 'teacher/view/manage_questions.php';
?>