<?php 
include_once('start.php');
   $emailAdmin 		= ADMINEMAIL;   		// This is the email address that will be used for outgoing emails
   $urlPath 		= HTTPROOT."/3rd/classifieds";     // This is the location of the marketplace... used in email links to activate postings
 
   // these two are used to log into the admin mode, change them to something you'll remember
	$username = "admin";
	$password = "admin123";
	
	// This key is used to remove postings, change the value inside the quotes to something obscure, 
	// you will never need to remember it, so make it really obscure. 
	$key	  = "qpalzmytghnb";
	
	// Strings for the RSS file 
	$rss_title = "Classifieds";
	$rss_description = "These are things for sale";

   $languageFile 	= "language/lang_english.php";  // This defines what language and corresponds with the file in the folder.
?>