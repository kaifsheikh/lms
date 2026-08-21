<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['admin']);
include BASE_PATH . 'admin/view/dashboard.php';
?>