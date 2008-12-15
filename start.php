<?php
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
define('CACHETIME', 300); // seconds
define('SITENAME', 'Mumbaionline.org.in'); 
define('SITEURL', HTTPROOT); 
define('ADMINNAME', 'Administrator'); 
define('ADMINEMAIL', 'admin@mumbaionline.org.in'); 

include_once('Classes/cache-kit.php'); 
$cache_active = true;  
$cache_folder = DOCROOT.'/cache/';

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
$common = new Common;
?>