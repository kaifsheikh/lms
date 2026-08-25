<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;


// Sirf logged-in user logout kar sakta hai
requireLogin();


// Logout sirf POST request se hoga
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}


// CSRF token verify karo
$csrf_token = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrf_token)) {
    http_response_code(403);
    exit('Invalid CSRF token');
}


// Session ke tamam variables remove karo
$_SESSION = [];


// Session cookie delete karo
if (ini_get('session.use_cookies')) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}


// Session destroy karo
session_destroy();


// Login page par redirect
header('Location: ' . BASE_URL . '/accounts/controller/login.php');
exit;