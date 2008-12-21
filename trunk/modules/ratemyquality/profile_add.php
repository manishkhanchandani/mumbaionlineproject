<?php
include_once('start.php');

if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include_once('Classes/ratequality.php');
	$ratequality = new ratequality($dbFrameWork);
	$msg = $ratequality->addProfile($_POST, $_FILES);
}
$url = HTTPROOT."/modules/ratemyquality/manage_profile.php";
header("Location: ".HTTPROOT."/index.php?msg=".urlencode($msg)."&initialUrl=".urlencode($url));
exit;
?>