<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;


// ---------------------------------------------------------
// Only Admin can access this page
// ---------------------------------------------------------

requireRole(['admin']);


$message = '';
$error = '';


// ---------------------------------------------------------
// Handle POST
// ---------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // -----------------------------------------------------
    // CSRF Protection
    // -----------------------------------------------------

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }


    // -----------------------------------------------------
    // Get Data
    // -----------------------------------------------------

    $user_id = filter_input(
        INPUT_POST,
        'user_id',
        FILTER_VALIDATE_INT
    );

    $new_status = $_POST['status'] ?? '';


    // -----------------------------------------------------
    // Validate User ID
    // -----------------------------------------------------

    if (!$user_id || $user_id <= 0) {

        $error = 'Invalid user ID.';

    // -----------------------------------------------------
    // Validate Status
    // -----------------------------------------------------

    } elseif (!in_array(
        $new_status,
        ['pending', 'approved', 'rejected'],
        true
    )) {

        $error = 'Invalid status selected.';

    } else {

        // -------------------------------------------------
        // Update Accountant
        // -------------------------------------------------

        $stmt = $conn->prepare(
            "UPDATE users
             SET status = ?
             WHERE id = ?
             AND role = 'accountant'"
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

                $message =
                    "Accountant status updated to " .
                    htmlspecialchars($new_status, ENT_QUOTES, 'UTF-8') .
                    ".";

            } else {

                $error =
                    'No accountant found with this ID, or status was already the same.';
            }

        } else {

            $error = 'Failed to update accountant status.';
        }

        $stmt->close();
    }
}


// ---------------------------------------------------------
// Get Accountants
// ---------------------------------------------------------

$result = $conn->query(
    "SELECT
        id,
        full_name,
        email,
        contact,
        status,
        created_at
     FROM users
     WHERE role = 'accountant'
     ORDER BY created_at DESC"
);


if (!$result) {
    http_response_code(500);
    exit('Database error.');
}


// ---------------------------------------------------------
// Load View
// ---------------------------------------------------------

include BASE_PATH . 'admin/view/accountant/approval.php';

?>