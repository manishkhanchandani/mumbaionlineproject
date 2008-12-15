<?php include_once('start.php'); ?>
<h1>Forgot Password</h1>
<div id="forgotMsg"></div>
<form id="form1" name="form1" method="post" action="">
  <p>Email: 
    <input name="email" type="text" id="email" value="<?php echo $_GET['email']; ?>" size="45" />
  </p>
  <p>
    <input type="button" name="Submit" value="Send My Password" onclick="str=getFormElements(this.form); doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/users/forgot_process.php','POST','', str, 'forgotMsg', 'yes', '', '0');" />
  </p>
</form>