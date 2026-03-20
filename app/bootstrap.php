<?php

// Load Config
require_once '../config/config.php';

// Load Helpers
require_once '../app/Helpers/url_helper.php';
require_once '../app/Helpers/session_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    // Replace backslashes with slashes
    $className = str_replace('\\', '/', $className);
    
    // Check if the file exists in app directory
    $file = '../' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
