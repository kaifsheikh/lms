<?php

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax'
    ]);

    session_start();
}


/*
|--------------------------------------------------------------------------
| Login Check
|--------------------------------------------------------------------------
*/

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id'], $_SESSION['role']);
}


/*
|--------------------------------------------------------------------------
| Get User Role
|--------------------------------------------------------------------------
*/

function getRole(): string
{
    return $_SESSION['role'] ?? '';
}


/*
|--------------------------------------------------------------------------
| Require Login
|--------------------------------------------------------------------------
*/

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/accounts/controller/login.php');
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Require Specific Role
|--------------------------------------------------------------------------
*/

function requireRole(array $allowed_roles): void
{
    requireLogin();

    if (!in_array(getRole(), $allowed_roles, true)) {
        http_response_code(403);
        exit('403 Forbidden');
    }
}


/*
|--------------------------------------------------------------------------
| CSRF Token
|--------------------------------------------------------------------------
*/

function getCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}


/*
|--------------------------------------------------------------------------
| Verify CSRF Token
|--------------------------------------------------------------------------
*/

function verifyCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) &&
           hash_equals($_SESSION['csrf_token'], $token);
}

?>