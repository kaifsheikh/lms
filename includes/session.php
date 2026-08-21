<?php
// Session start karo agar already start nahi hai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check karo user login hai ya nahi
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Role return karo
function getRole() {
    return $_SESSION['role'] ?? '';
}

// Agar login nahi hai to login page par bhejo
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /lms/accounts/controller/login.php');
        exit;
    }
}

// Kisi specific role ke liye check karo
function requireRole($allowed_roles) {
    requireLogin();
    if (!in_array(getRole(), $allowed_roles)) {
        header('Location: /lms/index.php');
        exit;
    }
}
?>