<?php
include_once('start.php');
function logout() {
	setcookie("user_id", '', (time()-300), "/");
	setcookie("email", '', (time()-300), "/");	
}
logout();
header("Location: ".HTTPROOT."/index.php");
exit;
?>