<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
if($_POST['emails']) {
	$emails = explode("\n", $_POST['emails']);
	if($emails) {
		// email
		include('Classes/Emailtemplate.php');
		
		foreach($emails as $email) {
			$Emailtemplate = new Emailtemplate;
			$patterns[0] = "{USEREMAIL}";
			$replacements[0] = $_COOKIE['email'];		
			$patterns[1] = "{MYLINK}";
			$replacements[1] = HTTPROOT."/modules/ratemyquality/index.php?id=".$_POST['id'];
			
			
			$to = $email;
			$Emailtemplate->template($to, 'ratemyqualitysendlink', $patterns, $replacements);
		}
		
		// email ends
	}
	echo '<p class="error">Link send successfully to all emails.</p>';
} else {
	echo '<p class="error">Please fill the email.</p>';
}
?>