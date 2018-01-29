<?php
define('ABSOLUTE_PATH', dirname(dirname(__FILE__)).'/');

session_start();
error_reporting(E_ALL);

define('DB_CHARSET', 'utf8');
define("REVATIVE_PATH", "admin");
define('IS_HTTPS', (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || isset($_SERVER['HTTP_X_HTTPS']) && $_SERVER['HTTP_X_HTTPS'] == '1'));
define('BASE_PATH', "http".(IS_HTTPS ? "s" : '')."://".getenv("HTTP_HOST")."/".(REVATIVE_PATH ? REVATIVE_PATH.'/' : ''));
define('CSS_PATH', "http".(IS_HTTPS ? "s" : '')."://".getenv("HTTP_HOST")."/assets/" );
header('Content-Type: text/html; charset=utf-8');

require_once ABSOLUTE_PATH.'config/main_config.php';
require_once ABSOLUTE_PATH.'includes/database.php';
require_once ABSOLUTE_PATH.'includes/notify.php'; // -добавил Игорь
DB::connect('mysqli://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME,true);

checkEventComplitedNotifyAsterisk(); // -добавил Игорь

?>