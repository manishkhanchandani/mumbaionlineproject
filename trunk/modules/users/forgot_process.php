<?php
include_once('start.php');
include_once('Connections/conn.php');
function forgot($email) {
	$rs = mysql_query("select * from user where email = '".addslashes(stripslashes(trim($_POST['email'])))."'");
	if(mysql_num_rows($rs)) {
		$rec = mysql_fetch_array($rs);
		$pass = $rec['password'];
		// email
		include('Classes/Emailtemplate.php');
		$Emailtemplate = new Emailtemplate;
		$patterns[0] = "{PASSWORD}";
		$replacements[0] = $rec['password'];		
		$patterns[1] = "{SITEURL}";
		$replacements[1] = SITEURL;
		$to = $rec['email'];
		$Emailtemplate->template($to, 'forgot', $patterns, $replacements);
		// email ends
		$msg = "Password successfully sent to your email.";
	} else {
		$msg = "Email is not valid. Our database does not contain this email. Please verify your email and try again.";
	}
	return $msg;
}
if($_POST) {
	if(!trim($_POST['email'])) {
		$msg = "Email field is blank.";
		echo $msg;
		exit;
	}
	if(!$common->emailvalidity(trim($_POST['email']))) {
		$msg = "Email field is not valid.";
		echo $msg;
		exit;
	}
	$msg = forgot($email);
	echo $msg;
	exit;
}
?>