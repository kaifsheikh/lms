<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Model object
$quizModel = new Quiz($conn);

// =====================================================
// HANDLE POST REQUESTS
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    // CREATE QUIZ
    if ($action === 'create_quiz') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $due_date = $_POST['due_date'] ?? '';
        $timer = intval($_POST['timer'] ?? 0);
        $passing_marks = intval($_POST['passing_marks'] ?? 0);
        $batch_id = intval($_POST['batch_id'] ?? 0);

        if (empty($title) || empty($due_date) || $timer <= 0 || $passing_marks <= 0) {
            $error = 'All fields are required. Timer and passing marks must be positive.';
        } elseif ($batch_id <= 0) {
            $error = 'Please select a batch.';
        } elseif (!$quizModel->verifyBatchOwnership($batch_id, $teacher_id)) {
            $error = 'Selected batch not found or does not belong to you.';
        } else {
            if ($quizModel->createQuiz($teacher_id, $batch_id, $title, $description, $due_date, $timer, $passing_marks)) {
                $success = 'Quiz created successfully!';
            } else {
                $error = 'Failed to create quiz.';
            }
        }
    }

    // DELETE QUIZ
    elseif ($action === 'delete_quiz') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        if ($quiz_id <= 0) {
            $error = 'Invalid quiz selected.';
        } elseif (!$quizModel->verifyQuizOwnership($quiz_id, $teacher_id)) {
            $error = 'Quiz not found or does not belong to you.';
        } else {
            if ($quizModel->deleteQuiz($quiz_id, $teacher_id)) {
                $success = 'Quiz deleted successfully.';
            } else {
                $error = 'Failed to delete quiz.';
            }
        }
    }

    // START QUIZ
    elseif ($action === 'start_quiz') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        if ($quiz_id <= 0) {
            $error = 'Invalid quiz selected.';
        } elseif (!$quizModel->verifyQuizOwnership($quiz_id, $teacher_id)) {
            $error = 'Quiz not found or does not belong to you.';
        } else {
            if ($quizModel->startQuiz($quiz_id, $teacher_id)) {
                $success = 'Quiz started successfully! Students can now see it.';
            } else {
                $error = 'Failed to start quiz.';
            }
        }
    }

    // CHANGE STATUS
    elseif ($action === 'change_status') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        $new_status = $_POST['new_status'] ?? '';
        $allowed_statuses = ['draft', 'active', 'closed'];

        if ($quiz_id <= 0 || !in_array($new_status, $allowed_statuses, true)) {
            $error = 'Invalid status change request.';
        } elseif (!$quizModel->verifyQuizOwnership($quiz_id, $teacher_id)) {
            $error = 'Quiz not found or does not belong to you.';
        } else {
            if ($quizModel->changeQuizStatus($quiz_id, $teacher_id, $new_status)) {
                $status_labels = [
                    'draft' => 'set to draft',
                    'active' => 'activated',
                    'closed' => 'closed'
                ];
                $success = 'Quiz ' . ($status_labels[$new_status] ?? 'updated') . ' successfully.';
            } else {
                $error = 'Failed to update quiz status.';
            }
        }
    }
}

// =====================================================
// FETCH QUIZZES AND BATCHES FOR VIEW
// =====================================================
$quizzes = $quizModel->getQuizzesWithBatchByTeacher($teacher_id);
$batches = $quizModel->getBatchesForTeacher($teacher_id);

// =====================================================
// LOAD VIEW
// =====================================================
include BASE_PATH . 'teacher/view/quiz_management.php';
?>