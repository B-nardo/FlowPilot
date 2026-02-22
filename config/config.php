<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'flowpilot');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application settings
define('BASE_URL', 'http://localhost/flowpilot/public');
define('APP_NAME', 'FlowPilot CRM');
define('APPROOT', dirname(__DIR__) . '/app'); 



// Start session
session_start();