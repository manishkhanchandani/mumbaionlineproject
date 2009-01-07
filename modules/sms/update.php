<?php
include_once('start.php');
try {	
	// user access
	if(!$_COOKIE['user_id']) {
		throw new Exception('Please login first to continue. ');	
	}	
	if($_GET['delId']) {
		// delete the record
		$common->deleteRecord('smsreminders', 'id', $_GET['delId']);
		$msg = 'Record Deleted';
	}
	if($_GET['statusId']) {
		// update the record
		$ret['status'] = $_GET['status'];
		$common->editRecord('smsreminders', 'id', $ret, $_GET['statusId']);
		$msg = 'Record Updated';
	}
	echo "<p class='error'>".$msg."</p>"; exit;
} catch(Exception $e) {
	echo "<p class='error'>".$e->getMessage()."</p>";
	exit;
}
?>