<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['teacher']);
include BASE_PATH . 'teacher/view/dashboard.php';
?>