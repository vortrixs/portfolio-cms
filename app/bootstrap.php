<?php

// Starts sessions
if (!headers_sent()) {
    session_start();
}

// Turn on/off error PHP error reporting
ini_set('display_errors', true);
error_reporting(E_ALL^E_NOTICE);

// Parsing configuration file
foreach (parse_ini_file('config.ini', true) as $key => $value) {
    $arr[$key] = (object) $value;
}
$ini = (object) $arr;

$GLOBALS['config'] = array(
    'remember' => array(
        'cookie_name' => $ini->cookie->name,
        'cookie_expiry' => (int) $ini->cookie->expiry
    ),
    'session' => array(
        'session_name' => $ini->session->session_name,
        'token_name' => $ini->session->token_name
    )
);

// Define constants
define('DB_HOST', $ini->db->host);
define('DB_USERNAME', $ini->db->username);
define('DB_PASSWORD', $ini->db->password);
define('DB_NAME', $ini->db->database);
define('ASSETS_ROOT', str_replace('index.php', 'assets', $_SERVER['PHP_SELF']));
define('DIRECTORY_ROOT', str_replace('/index.php', '', $_SERVER['PHP_SELF']));
define('ADMIN_ROOT', str_replace('/index.php', '/admin', $_SERVER['PHP_SELF']));
define('CONTROLLERS', __DIR__ . '/Framework/Controllers');
define('CORE', __DIR__ . '/Framework/Core');
define('FUNCTIONS', __DIR__ . '/Framework/Functions');
define('INCLUDES', __DIR__ . '/Framework/Includes');
define('LIBS', __DIR__ . '/Framework/Libs');
define('MODELS', __DIR__ . '/Framework/Models');
define('VIEWS', __DIR__ . '/Framework/Views');

// Require in composer autoloader
require_once '../vendor/autoload.php';

// Pre-load functions
foreach (glob(FUNCTIONS . "/*.php") as $function) {
    require_once $function;
}
