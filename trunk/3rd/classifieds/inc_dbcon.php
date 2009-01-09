<?php
include_once('start.php');
	// Change these to be for your database
	$dbhostname = $hostname_conn;
	$dbname 	= $database_conn;
	$dbusername = $username_conn;
	$dbpassword = $password_conn;		

if(!$dbConn = mysql_connect($dbhostname, $dbusername, $dbpassword))
	die('I could not connect to the server my friend.');
if(!mysql_select_db($dbname, $dbConn))
	die('I could not select the database my friend.');
?>