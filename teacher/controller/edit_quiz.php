<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$old = [];

// Quiz ID validation
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    exit('Invalid Quiz ID.');
}

$quiz_id = (int) $_GET['id'];
if ($quiz_id <= 0) {
    http_response_code(400);
    exit('Invalid Quiz ID.');
}

// Model object
$quizModel = new Quiz($conn);

// Fetch quiz via model
$quiz = $quizModel->getQuizByIdAndTeacher($quiz_id, $teacher_id);

if (!$quiz) {
    http_response_code(404);
    exit('Quiz not found or does not belong to you.');
}

$old = $quiz;

// ==========================================================
// UPDATE QUIZ
// ==========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF CHECK
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // GET FORM DATA
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = trim($_POST['due_date'] ?? '');

    if (!empty($due_date)) {
        $due_date = str_replace('T', ' ', $due_date);
        if (strlen($due_date) === 16) {
            $due_date .= ':00';
        }
    }

    $timer = filter_input(INPUT_POST, 'timer', FILTER_VALIDATE_INT);
    $passing_marks = filter_input(INPUT_POST, 'passing_marks', FILTER_VALIDATE_INT);
    $batch_id = filter_input(INPUT_POST, 'batch_id', FILTER_VALIDATE_INT);

    // KEEP OLD VALUES FOR FORM
    $old = [
        'id' => $quiz_id,
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date,
        'timer' => $timer ?: 0,
        'passing_marks' => $passing_marks ?: 0,
        'batch_id' => $batch_id ?: 0
    ];

    // VALIDATION
    if (
        empty($title) ||
        empty($due_date) ||
        $timer === false || $timer <= 0 ||
        $passing_marks === false || $passing_marks <= 0 ||
        $batch_id === false || $batch_id <= 0
    ) {
        $error = 'All fields are required. Timer, passing marks and batch must be valid.';
    } else {
        // VERIFY BATCH via model
        if (!$quizModel->verifyBatchOwnership($batch_id, $teacher_id)) {
            $error = 'Selected batch not found, does not belong to you, or is not approved.';
        } else {
            // UPDATE QUIZ via model
            if ($quizModel->updateQuiz($quiz_id, $teacher_id, $title, $description, $batch_id, $due_date, $timer, $passing_marks)) {
                $_SESSION['quiz_success'] = 'Quiz updated successfully!';
                header('Location: ' . BASE_URL . '/teacher/controller/quiz_management.php');
                exit;
            } else {
                $error = 'Failed to update quiz.';
            }
        }
    }
}

// Fetch approved batches for dropdown via model
$batches = $quizModel->getApprovedBatchesForTeacher($teacher_id);

// Load view
include BASE_PATH . 'teacher/view/edit_quiz.php';
?>