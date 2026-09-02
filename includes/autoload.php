<?php
// Autoloader sirf models folder ke liye
spl_autoload_register(function ($class_name) {
    // Models ka path
    $model_file = BASE_PATH . 'models/' . $class_name . '.php';
    
    if (file_exists($model_file)) {
        require_once $model_file;
    }
});