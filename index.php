<?php

require_once __DIR__ . '/config.php';
require_once SESSION;

if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/' . getRole() . '/controller/dashboard.php');
    exit;
}

header('Location: ' . BASE_URL . '/accounts/controller/login.php');
exit;
?>