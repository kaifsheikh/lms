<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;


// ---------------------------------------------------------
// Already logged-in user ko dashboard par bhejo
// ---------------------------------------------------------

if (isLoggedIn()) {
    header(
        'Location: ' .
        BASE_URL .
        '/' .
        getRole() .
        '/controller/dashboard.php'
    );
    exit;
}


$error = '';
$old = [];


// ---------------------------------------------------------
// Registration Form Submit
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
    // Get Form Data
    // -----------------------------------------------------

    $old = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email'     => trim($_POST['email'] ?? ''),
        'contact'   => trim($_POST['contact'] ?? ''),
        'role'      => $_POST['role'] ?? ''
    ];

    $password = $_POST['password'] ?? '';


    // -----------------------------------------------------
    // Validation
    // -----------------------------------------------------

    if (
        empty($old['full_name']) ||
        empty($old['email']) ||
        empty($password) ||
        empty($old['contact']) ||
        empty($old['role'])
    ) {

        $error = 'All fields are required.';

    } elseif (strlen($old['full_name']) > 100) {

        $error = 'Full name is too long.';

    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {

        $error = 'Invalid email format.';

    } elseif (strlen($old['email']) > 255) {

        $error = 'Email address is too long.';

    } elseif (strlen($old['contact']) > 30) {

        $error = 'Contact number is too long.';

    } elseif (strlen($password) < 8) {

        $error = 'Password must be at least 8 characters.';

    } elseif (
        !in_array(
            $old['role'],
            ['admin', 'teacher'],
            true
        )
    ) {

        $error = 'Invalid role selected.';

    } else {

        // -------------------------------------------------
        // Check Existing Email
        // -------------------------------------------------

        $stmt = $conn->prepare(
            "SELECT id
             FROM users
             WHERE email = ?"
        );

        if (!$stmt) {
            http_response_code(500);
            exit('Database error.');
        }

        $stmt->bind_param("s", $old['email']);
        $stmt->execute();
        $stmt->store_result();


        if ($stmt->num_rows > 0) {

            $error = 'Email already registered.';

            $stmt->close();

        } else {

            $stmt->close();


            // -------------------------------------------------
            // Hash Password
            // -------------------------------------------------

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $status = 'pending';


            // -------------------------------------------------
            // Insert User
            // -------------------------------------------------

            $stmt = $conn->prepare(
                "INSERT INTO users
                (full_name, email, password, contact, role, status)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            if (!$stmt) {
                http_response_code(500);
                exit('Database error.');
            }

            $stmt->bind_param(
                "ssssss",
                $old['full_name'],
                $old['email'],
                $hashed_password,
                $old['contact'],
                $old['role'],
                $status
            );


            if ($stmt->execute()) {

                $stmt->close();

                $_SESSION['success'] =
                    'Registration successful! Please wait for admin approval before login.';

                header(
                    'Location: ' .
                    BASE_URL .
                    '/accounts/controller/login.php'
                );

                exit;

            } else {

                $error = 'Something went wrong. Please try again.';

                $stmt->close();
            }
        }
    }
}


// ---------------------------------------------------------
// Registration View
// ---------------------------------------------------------

include BASE_PATH . 'accounts/view/register.php';

?>