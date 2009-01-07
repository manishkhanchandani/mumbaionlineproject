<?php
include_once('start.php');
try {	
	// user access
	if(!$_COOKIE['user_id']) {
		throw new Exception('Please login first to continue. ');	
	}
	include_once('Classes/SMS.php');
	$SMS = new SMS;
	$SMS->validateForm($_POST);
	$_POST['user_id'] = $_COOKIE['user_id'];
	$time1 = strtotime($_POST['smsdatetime']);
	$time2 = explode(":", $_POST['smstime']);
	$time3 = mktime($time2[0], $time2[1], 0, date('m', $time1), date('d', $time1), date('Y', $time1));
	$_POST['senddate'] = $time3;
	$_POST['smsdatetime'] = date('Y-m-d H:i:s', $time3);
	$common->insertRecord("smsreminders", "id", $_POST);
	$message = 'SMS Created Successfully. SMS will be sent as per your details. ';
	echo "<p class='error'>".$message."</p>";
	
	// send cron for now on each individual page, later on put it in cron jobs.
	$SMS->cronSMS();
	
	exit;
} catch(Exception $e) {
	echo "<p class='error'>".$e->getMessage()."</p>";
	exit;
}

?>