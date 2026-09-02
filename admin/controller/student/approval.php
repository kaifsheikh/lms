<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';

// Model object banao
$studentModel = new Student($conn);

// ---------------------------------------------------------
// Handle POST
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $new_status = $_POST['status'] ?? '';

    if (!$user_id || $user_id <= 0) {
        $error = 'Invalid student ID.';
    } elseif (!in_array($new_status, ['pending', 'process', 'active'], true)) {
        $error = 'Invalid status selected.';
    } else {
        // Model ka method call karo
        $result = $studentModel->updateStatus($user_id, $new_status);

        if ($result['success']) {
            if ($result['affected'] > 0) {
                $message = 'Student status updated successfully.';
            } else {
                $error = 'Student not found or status is already the same.';
            }
        } else {
            $error = 'Failed to update student status.';
        }
    }
}

// ---------------------------------------------------------
// Get Students via model
// ---------------------------------------------------------
$students = $studentModel->getAllStudents();

// ---------------------------------------------------------
// Load View
// ---------------------------------------------------------
include BASE_PATH . 'admin/view/student/approval.php';
?>