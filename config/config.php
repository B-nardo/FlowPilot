<?php
// Database configuration
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

// Application settings
define('BASE_URL', getenv('BASE_URL'));
define('APP_NAME', 'FlowPilot CRM');
define('APPROOT', dirname(__DIR__) . '/app'); 



// Start session
session_start();