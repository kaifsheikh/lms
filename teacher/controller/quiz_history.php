<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Model object
$quizModel = new Quiz($conn);

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_history') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $history_id = intval($_POST['history_id'] ?? 0);
    if ($history_id <= 0) {
        $error = 'Invalid record.';
    } else {
        $result = $quizModel->deleteQuizHistory($history_id, $teacher_id);
        if ($result['success'] && $result['affected'] > 0) {
            $message = 'Record deleted successfully.';
        } else {
            $error = 'Record not found or you do not have permission.';
        }
    }
}

// Fetch history via model
$history = $quizModel->getQuizHistoryByTeacher($teacher_id);

include BASE_PATH . 'teacher/view/quiz_history.php';
?>