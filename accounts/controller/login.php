<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;


// ---------------------------------------------------------
// Already logged in user ko dashboard par bhejo
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


// ---------------------------------------------------------
// Variables
// ---------------------------------------------------------

$error = '';
$old = [];
$success = '';


// ---------------------------------------------------------
// Session success message
// ---------------------------------------------------------

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}


// ---------------------------------------------------------
// Login Form Submit
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

    $old['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    // -----------------------------------------------------
    // Basic Validation
    // -----------------------------------------------------

    if (empty($old['email']) || empty($password)) {

        $error = 'Email and password are required.';

    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {

        $error = 'Invalid email format.';

    } else {

        $role = '';
        $user_id = null;
        $full_name = '';
        $hashed_password = '';
        $status = '';


        // =================================================
        // 1. Check users table
        // Admin / Teacher / Accountant
        // =================================================

        $stmt = $conn->prepare(
            "SELECT id, full_name, password, role, status
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

            $stmt->bind_result(
                $user_id,
                $full_name,
                $hashed_password,
                $role,
                $status
            );

            $stmt->fetch();

        } else {

            // Close users query
            $stmt->close();


            // =================================================
            // 2. Check students table
            // =================================================

            $stmt = $conn->prepare(
                "SELECT id, full_name, password, 'student' AS role, status
                 FROM students
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

                $stmt->bind_result(
                    $user_id,
                    $full_name,
                    $hashed_password,
                    $role,
                    $status
                );

                $stmt->fetch();

            } else {

                // Generic message — email enumeration se protection
                $error = 'Invalid email or password.';
            }
        }


        // =================================================
        // Password Verification
        // =================================================

        if (empty($error)) {

            if (!password_verify($password, $hashed_password)) {

                $error = 'Invalid email or password.';

            } else {

                // =================================================
                // STUDENT
                // =================================================

                if ($role === 'student') {

                    if ($status === 'pending') {

                        $error = 'Your student account is pending approval.';

                    } elseif ($status === 'process') {

                        $error = 'Your student application is under process.';

                    } elseif ($status === 'active') {

                        // -----------------------------------------
                        // Successful student login
                        // -----------------------------------------

                        session_regenerate_id(true);

                        $_SESSION['user_id']   = $user_id;
                        $_SESSION['user_name'] = $full_name;
                        $_SESSION['role']      = $role;

                        header(
                            'Location: ' .
                            BASE_URL .
                            '/student/controller/dashboard.php'
                        );
                        exit;

                    } else {

                        $error = 'Invalid student status.';
                    }


                // =================================================
                // ADMIN / TEACHER / ACCOUNTANT
                // =================================================

                } else {

                    if ($status === 'pending') {

                        $error = 'Your account is pending approval by admin.';

                    } elseif ($status === 'rejected') {

                        $error = 'Your account has been rejected by admin.';

                    } else {

                        // -----------------------------------------
                        // Successful user login
                        // -----------------------------------------

                        session_regenerate_id(true);

                        $_SESSION['user_id']   = $user_id;
                        $_SESSION['user_name'] = $full_name;
                        $_SESSION['role']      = $role;

                        header(
                            'Location: ' .
                            BASE_URL .
                            '/' .
                            $role .
                            '/controller/dashboard.php'
                        );
                        exit;
                    }
                }
            }
        }


        // -----------------------------------------------------
        // Close statement
        // -----------------------------------------------------

        if (isset($stmt)) {
            $stmt->close();
        }
    }
}


// ---------------------------------------------------------
// Login View
// ---------------------------------------------------------

include BASE_PATH . 'accounts/view/login.php';

?>