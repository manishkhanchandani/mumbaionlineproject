<?php
 	include_once('config.php');
	include_once($languageFile);
	// This file is used when a user has a post, there is a link that will send a reminder email to themselves so they can delete post.

	$headers = 'From: ' . $emailAdmin . "\r\n" .
   'Reply-To: ' . $emailAdmin . "\r\n" .
   'X-Mailer: PHP/' . phpversion();	

	// Email Content
	$message .= STR_IFYOURPOSTING;
	$message .= STR_BUTSTILL;
	$message .=	STR_TODEACTIVATE;
	$message .=	$urlPath  . "/action.php?a=deact&cp=".$confirmPassword . "\n\n";
	$message .=	STR_TODELETE;
	$message .= $urlPath  . "/action.php?a=delete&cp=".$confirmPassword ;
	$message .= STR_IPREQUESTED . GetHostByName($REMOTE_ADDR);
?>
