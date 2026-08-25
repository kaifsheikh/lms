<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';


// ---------------------------------------------------------
// Handle POST
// ---------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // Validate User ID
    $user_id = filter_input(
        INPUT_POST,
        'user_id',
        FILTER_VALIDATE_INT
    );

    // Get status
    $new_status = $_POST['status'] ?? '';

    // Validate ID
    if (!$user_id || $user_id <= 0) {

        $error = 'Invalid student ID.';

    // Validate status
    } elseif (!in_array(
        $new_status,
        ['pending', 'process', 'active'],
        true
    )) {

        $error = 'Invalid status selected.';

    } else {

        // Update student status
        $stmt = $conn->prepare(
            "UPDATE students
             SET status = ?
             WHERE id = ?"
        );

        if (!$stmt) {
            http_response_code(500);
            exit('Database error.');
        }

        $stmt->bind_param(
            "si",
            $new_status,
            $user_id
        );

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {

                $message = 'Student status updated successfully.';

            } else {

                $error =
                    'Student not found or status is already the same.';
            }

        } else {

            $error = 'Failed to update student status.';
        }

        $stmt->close();
    }
}


// ---------------------------------------------------------
// Get Students
// ---------------------------------------------------------

$result = $conn->query(
    "SELECT
        id,
        full_name,
        email,
        contact,
        status,
        created_at
     FROM students
     ORDER BY created_at DESC"
);

if (!$result) {
    http_response_code(500);
    exit('Database error.');
}


// ---------------------------------------------------------
// Load View
// ---------------------------------------------------------

include BASE_PATH . 'admin/view/student/approval.php';

?>