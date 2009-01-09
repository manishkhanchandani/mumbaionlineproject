<?php 
session_start();

if (isset($_POST['op'])) {
	if ($_POST['op'] == "login"){
		 include("config.php");
		 if ($_POST['p'] == $password && $_POST['u'] == $username) {
			 $_SESSION['username'] = $username;
			 header("Location:index.php?m=yes");
		 } else {
		 header("Location:login.php?msg=Login%20Failed,%20Please%20Try%20Again");
		 }
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log In</title>
<link href="../md_style.css" rel="stylesheet" type="text/css" />
<link href="md_admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1 class="title">Admin Login</h1>
<?php 
	if (isset($_GET["msg"]))
	print("<div class='md_msg'>" . $_GET["msg"]. "</div>&nbsp;<br>"); 
?>

<form name='form1' method='post' action="login.php">
  <table cellpadding="4" style='border:1px solid #cccccc; background-color:#ebebeb;'>
    <tr> 
      <td>User Name</td>
      <td><input type="text" name='u' maxlength='22'></td>
    </tr>
    <tr> 
      <td>Password</td>
      <td><input type="password" name='p' maxlength='22'> <input type='hidden' name='op' value='login'> 
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Sign In" /></td>
    </tr>
  </table>
  <p>Note: If you forgot the user name and password, it's in the config file in 
    this folder.</p>
  <p><a href="http://www.matterdaddy.com/phpbb3">Matterdaddy Market support site</a></p>
</form>
<script language="JavaScript">
document.form1.u.focus();
</script>

</body>
</html>
