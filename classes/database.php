<?php 
require_once(LIB_PATH.DS.'config.php');
$db_name = DB_NAME;
$db_host = DB_SERVER;
try {
	$database = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8",DB_USER, DB_PASS);
	//$db = new PDO("mysql:host=localhost;dbname=alex_innovation;charset=utf8",'root', 'ignition');
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//var_dump($db);	
}
catch(Exception $e){
	die("Database Connection failed. " .$e->getMessage());
}

$db =& $database;

?>