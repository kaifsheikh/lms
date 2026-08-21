<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
requireRole(['student']);
include BASE_PATH . 'student/view/dashboard.php';
?>