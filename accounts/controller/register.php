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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // Get Form Data
    $old = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email'     => trim($_POST['email'] ?? ''),
        'contact'   => trim($_POST['contact'] ?? ''),
        'role'      => $_POST['role'] ?? ''
    ];

    $password = $_POST['password'] ?? '';

    // Validation
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
    } elseif (!in_array($old['role'], ['admin', 'teacher'], true)) {
        $error = 'Invalid role selected.';
    } else {

        if ($userModel->emailExists($old['email'])) {

            $error = 'Email already registered.';

        } else {

            if ($userModel->createUser(
                $old['full_name'],
                $old['email'],
                $password,
                $old['contact'],
                $old['role'],
                'pending'
            )) {

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
            }
        }
    }
}

include BASE_PATH . 'accounts/view/register.php';
?>