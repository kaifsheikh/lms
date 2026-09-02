<?php
// Base Path (automatically detect project root)
define('BASE_PATH', __DIR__ . '/');

// URL base (adjust if project is in subfolder, e.g., /lms)
define('BASE_URL', '/lms');

// Includes
define('INCLUDES_PATH', BASE_PATH . 'includes/');
define('HEADER', INCLUDES_PATH . 'header.php');
define('FOOTER', INCLUDES_PATH . 'footer.php');
define('SESSION', INCLUDES_PATH . 'session.php');
define('DB', INCLUDES_PATH . 'db.php');
require_once INCLUDES_PATH . 'autoload.php';
?>