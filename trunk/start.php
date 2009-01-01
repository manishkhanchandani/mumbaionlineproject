<?php
error_reporting(E_ALL ^ E_NOTICE);
ob_start();
require_once('Connections/conn.php');

$TIMESTART = microtime(true);
define('DOCROOT', dirname(__FILE__));
if($_SERVER['HTTP_HOST']=="localhost") {
	$HTTPROOT = "http://".$_SERVER['HTTP_HOST']."/december2008";
} else if(eregi("10000projects.info", $_SERVER['HTTP_HOST'])) {
	$HTTPROOT = "http://".$_SERVER['HTTP_HOST']."/december2008";
} else {
	$HTTPROOT = "http://".$_SERVER['HTTP_HOST'];
}
define('HTTPROOT', $HTTPROOT);

//echo DOCROOT;
//echo "<br>";
//echo HTTPROOT;
//echo "<br>";
define('CACHETIME', 1500); // seconds
define('SITENAME', 'Mumbaionline.org.in'); 
define('SITEURL', HTTPROOT); 
define('ADMINNAME', 'Administrator'); 
define('ADMINEMAIL', 'admin@mumbaionline.org.in'); 
define('EXTENSION', 'mumbai'); 
define('MUSICDEFAULT', '/assets/music/SatyamShivamSundaram.mp3'); 

// adodb connection
include('adodb/adodb-exceptions.inc.php'); # load code common to ADOdb
include('adodb/adodb.inc.php'); # load code common to ADOdb 

$ADODB_CACHE_DIR = DOCROOT.'/ADODB_cache'; 
//$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
//$dbFrameWork->Connect('remote-mysql3.servage.net','framework2008','framework2008','framework2008');# connect to MySQL, framework db
try { 
	$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
	if($_SERVER['HTTP_HOST']=="localhost") {
		$dbFrameWork->Connect('localhost','user','password','december2008');# connect to MySQL, framework db
	} else {
		$dbFrameWork->Connect('remote-mysql4.servage.net','december2008','december2008','december2008');# connect to MySQL, framework db
	}
} catch (exception $e) { 
	ob_end_clean();
	echo 'Loading in 5 seconds. If page does not refresh in 5 seconds, please refresh manually.<meta http-equiv="refresh" content="5">';
	//echo "<pre>";var_dump($e); adodb_backtrace($e->gettrace());
	exit;
} 
// adodb connection ends

include_once('Classes/cache-kit.php'); 
$cache_active = true;  
$cache_folder = DOCROOT.'/cache/';
define('CACHEFOLDER', $cache_folder);
if(!function_exists('checkcache')) {
	function checkcache($j, $time=CACHETIME){ 
		$result = acmeCache::fetch($j, $time); // 10 seconds 
		return $result; 
	} 
}

if(!function_exists('cachefunction')) {
	function cachefunction($j, $result=""){ 
		acmeCache::save($j, $result); 
		return 1;
	} 
}

include_once('Classes/Common.php');
$common = new Common($dbFrameWork);
?>