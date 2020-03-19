<?php
define('ABSPATH', __DIR__);
define('ADMIN_PATH', ABSPATH.'/admin');
define('ADMIN_SCRIPT_PATH', ADMIN_PATH.'/script');

ini_set('display_errors', 1);
session_start();
require_once ADMIN_PATH.'/connect.php';
require_once ADMIN_SCRIPT_PATH.'/login.php';
require_once ADMIN_SCRIPT_PATH.'/location.php';
require_once ADMIN_SCRIPT_PATH.'/user.php';





