<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/User.php';

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

$userModel = new User($conn);

$error = '';
$old = [];
$success = '';

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // Get Form Data
    $old['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic Validation
    if (empty($old['email']) || empty($password)) {

        $error = 'Email and password are required.';

    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {

        $error = 'Invalid email format.';

    } else {

        $user = $userModel->findByEmail($old['email']);

        if (!$user) {
            $user = $userModel->findStudentByEmail($old['email']);
        }

        if (!$user) {
            $error = 'Invalid email or password.';
        } else {

            // Password Verification
            if (!password_verify($password, $user['password'])) {

                $error = 'Invalid email or password.';

            } else {

                $role      = $user['role'];
                $status    = $user['status'];
                $user_id   = $user['id'];
                $full_name = $user['full_name'];

                if ($role === 'student') {

                    if ($status === 'pending') {

                        $error = 'Your student account is pending approval.';

                    } elseif ($status === 'process') {

                        $error = 'Your student application is under process.';

                    } elseif ($status === 'active') {

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

                } else {

                    if ($status === 'pending') {

                        $error = 'Your account is pending approval by admin.';

                    } elseif ($status === 'rejected') {

                        $error = 'Your account has been rejected by admin.';

                    } else {

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
    }
}

include BASE_PATH . 'accounts/view/login.php';
?>