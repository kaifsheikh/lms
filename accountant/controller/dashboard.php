<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['accountant']);
include BASE_PATH . 'accountant/view/dashboard.php';
?>