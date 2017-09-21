<?php
define('__ROOT__','http://'.$_SERVER["HTTP_HOST"]);
$dirname = dirname(__FILE__).'/db.php';
 if(strpos($dirname,'nginx/html') > 0){
 	define('DB_NAME','root');
 	define('DB_PASS','chinamobile');
 	define('DB_STR','mysql:host=172.17.91.195;port=3306;dbname=mobile');
 }else{
	define('DB_NAME','root');
	define('DB_PASS','');
	define('DB_STR','mysql:host=localhost;dbname=mobile');
 }
define('CACHETIME','1');
define('STATIONID','66');
