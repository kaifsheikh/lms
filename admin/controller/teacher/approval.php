<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['admin']);

$message = '';
$error = '';

// Model object
$userModel = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // Required fields check
    if (!isset($_POST['user_id'], $_POST['status'])) {
        $error = 'Invalid request.';
    } else {
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $new_status = $_POST['status'];

        // Validate user ID
        if ($user_id === false || $user_id <= 0) {
            $error = 'Invalid teacher ID.';
        }
        // Validate status
        elseif (!in_array($new_status, ['pending', 'approved', 'rejected'], true)) {
            $error = 'Invalid status selected.';
        } else {
            // Update via model
            $result = $userModel->updateTeacherStatus($user_id, $new_status);

            if ($result['success']) {
                if ($result['affected'] > 0) {
                    $message = "Teacher status updated to $new_status.";
                } else {
                    $error = 'Teacher not found or status was already the same.';
                }
            } else {
                $error = 'Failed to update teacher status.';
            }
        }
    }
}

// Fetch teachers via model
$teachers = $userModel->getTeachers();

include BASE_PATH . 'admin/view/teacher/approval.php';
?>