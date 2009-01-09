<?php
	include_once('config.php');
	include_once($languageFile);
	
	$headers = 'From: ' . $emailAdmin . "\r\n" .
   'Reply-To: ' . $emailAdmin . "\r\n" .
   'X-Mailer: PHP/' . phpversion();	
	// Email Content
	$message = STR_ONELASTSTEP;
	$message .= $urlPath  . "/action.php?a=confirm&cp=".$confirmPassword;
	$message .= STR_DONTTHROWTHISMAIL;
	$message .= STR_POSTINGFULLFILLED;
	$message .= STR_STILLACTIVITY;
	$message .=	STR_TODEACTIVATEPOSTING;
	$message .=  $urlPath  . "/action.php?a=deact&cp=".$confirmPassword . "\n\n";
	$message .=	STR_TODELETEPOSTING;
	$message .=  $urlPath  . "/action.php?a=delete&cp=".$confirmPassword;
?>