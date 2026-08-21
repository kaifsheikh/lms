<?php
require_once 'includes/session.php';

if (isLoggedIn()) {
    $role = getRole();
    header('Location: /lms/' . $role . '/controller/dashboard.php');
    exit;
} else {
    header('Location: /lms/accounts/controller/login.php');
    exit;
}
?>