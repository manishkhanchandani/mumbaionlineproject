<?php include_once('start.php'); ?>
<h1>Login/Register</h1>
<?php if($_GET['msg']) { ?>
<p class="error"><?php echo $_GET['msg']; ?></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="modules/users/login_process.php">
  <p>Email: 
    <input name="email" type="text" id="email" value="<?php echo $_GET['email']; ?>" size="45" />
</p>
  <p>Password: 
    <input name="password" type="password" id="password" size="20" />
</p>
  <p>
    <input name="remember" type="checkbox" id="remember" value="1" />
  Remember Me | <a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/users/forgot.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/users/forgot.php"); ?>', '1');">Forgot Password</a> </p>
  <p>
    <input type="submit" name="Submit" value="Login/Register" />
  </p>
</form>