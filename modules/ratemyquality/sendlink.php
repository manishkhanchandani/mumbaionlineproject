<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
?>
<h1>Invite Friends To Vote Your Profile</h1>
<?php include(DOCROOT."/modules/ratemyquality/menu.php"); ?>
<div id="ratemyqualityconfirm"></div>
<form id="form1" name="form1" method="post" action="">
  <p>Email: (put each email in new line) <br />
    <textarea name="emails" cols="45" rows="10" id="emails"></textarea>
</p>
  <p>
    <input type="button" name="Submit" value="Send Invitation" onclick="str=getFormElements(this.form); doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/sendlinkconfirm.php','POST','', str, 'ratemyqualityconfirm', 'yes', '', '0');" />
    <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" />
  </p>
</form>
<p>&nbsp;</p>