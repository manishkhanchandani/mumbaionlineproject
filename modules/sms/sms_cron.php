<?php
include_once('start.php');
try {	
	include_once('Classes/SMS.php');
	$SMS = new SMS;
	$result = $SMS->cronSMS();
	$message = 'SMS sent successfully.';
	echo "<p class='error'>".$message."</p>";
	exit;
} catch(Exception $e) {
	echo "<p class='error'>".$e->getMessage()."</p>";
	exit;
}
?>