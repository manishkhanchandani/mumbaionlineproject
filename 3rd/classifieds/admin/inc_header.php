<?php 
session_start();

if (!isset($_SESSION['username'])){
	header("Location: login.php?msg=Please%20Login");
	// This stuff is here if you have redirection turned off in browser - eg Opera
	print("<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>");
	include("inc_header.php");
	print("<p>Please <a href='index.php'><b>login</b></a> to begin.");
	exit();	
} 
$username = $_SESSION['username'];
?>