<?php
include_once('start.php');
include_once('Connections/conn.php');
function login($id, $rem, $email) {
	if($rem) $time = time()+(60*60*24*365);
	else $time = 0;
	setcookie("user_id", $id, $time, "/");
	setcookie("email", $email, $time, "/");	
}
if($_POST) {
	if(!trim($_POST['email'])) {
		$msg = "Email field is blank.";
		$initialUrl = "modules/users/login.php";
		header("Location: ../../index.php?email=".$_POST['email']."&msg=".urlencode($msg)."&initialUrl=".urlencode($initialUrl));
		exit;
	}
	if(!trim($_POST['password'])) {
		$msg = "Password field is blank.";
		$initialUrl = "modules/users/login.php";
		header("Location: ../../index.php?email=".$_POST['email']."&msg=".urlencode($msg)."&initialUrl=".urlencode($initialUrl));
		exit;	
	}
	if(!$common->emailvalidity(trim($_POST['email']))) {
		$msg = "Email field is not valid.";
		$initialUrl = "modules/users/login.php";
		header("Location: ../../index.php?email=".$_POST['email']."&msg=".urlencode($msg)."&initialUrl=".urlencode($initialUrl));
		exit;
	}
	$sql = "select * from user where email = '".addslashes(stripslashes(trim($_POST['email'])))."'";
	$rs = mysql_query($sql) or die('error in line number '.__LINE__." due to ".mysql_error());
	if(mysql_num_rows($rs)==0) {
		// register this user
		$sql = "insert into user set email = '".addslashes(stripslashes(trim($_POST['email'])))."', password = '".addslashes(stripslashes(trim($_POST['password'])))."', code = '', active = 1, lastlogin = '".date('Y-m-d H:i:s')."'";
		$rs = mysql_query($sql) or die('error in line number '.__LINE__." due to ".mysql_error());
		$id = mysql_insert_id();
		login($id, addslashes(stripslashes(trim($_POST['remember']))), addslashes(stripslashes(trim($_POST['email']))));		
		// email
		include('Classes/Emailtemplate.php');
		$Emailtemplate = new Emailtemplate;
		$patterns[0] = "{PASSWORD}";
		$replacements[0] = $_POST['password'];		
		$patterns[1] = "{SITEURL}";
		$replacements[1] = SITEURL;
		$patterns[2] = "{EMAIL}";
		$replacements[2] = $_POST['email'];
		$to = $_POST['email'];
		$Emailtemplate->template($to, 'register', $patterns, $replacements);
		// email ends
	} else {
		// check password
		$sql = "select * from user where email = '".addslashes(stripslashes(trim($_POST['email'])))."' and password = '".addslashes(stripslashes(trim($_POST['password'])))."'";
		$rs = mysql_query($sql) or die('error in line number '.__LINE__." due to ".mysql_error());
		if(mysql_num_rows($rs)==0) {
			// password is not matching
			$msg = "Email and Password Does Not Matches";
			$initialUrl = "modules/users/login.php";
			header("Location: ../../index.php?email=".$_POST['email']."&msg=".urlencode($msg)."&initialUrl=".urlencode($initialUrl));
			exit;
		} else {
			$rec = mysql_fetch_array($rs);
			login($rec['user_id'], addslashes(stripslashes(trim($_POST['remember']))), addslashes(stripslashes(trim($_POST['email']))));
		}
	}
	$msg = "You are successfully logged on our site";
	header("Location: ../../confirm.php?msg=".urlencode($msg));
	exit;
}
?>