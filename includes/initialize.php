<?php 

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', 
	DS.'wamp'.DS.'www'.DS.'Novateur');
	defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'classes');
require_once(LIB_PATH.DS."config.php");
require_once(SITE_ROOT.DS.'includes'.DS."functions.php");
//require_once(LIB_PATH.DS."func.php");
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'form.php');

require_once(LIB_PATH.DS."session.php");
//require_once(LIB_PATH.DS."user.php");

?>