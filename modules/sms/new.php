<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo 'Please login first.';
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Add New Reminder</title>
<!-- InstanceEndEditable -->
<script type="text/javascript">
var HTTPROOT = "<?php echo HTTPROOT; ?>";
</script>
<link href="<?php echo HTTPROOT; ?>/assets/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo HTTPROOT; ?>/libs/jquery/jquery-1.2.6.js"></script>
<!-- Menu System -->
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/jquery/treeview/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/jquery/treeview/screen.css" />

<script src="<?php echo HTTPROOT; ?>/libs/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo HTTPROOT; ?>/libs/jquery/treeview/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">	
	$(function() {
		$("#tree").treeview({
			collapsed: true,
			animated: "medium",
			control:"#sidetreecontrol",
			persist: "location"
		});
	})	
</script>
<!-- Menu System -->

<!-- datepicker -->
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/core.ui.datepicker/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="<?php echo HTTPROOT; ?>/libs/core.ui.datepicker/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<!-- datepicker ends -->
<script src="<?php echo HTTPROOT; ?>/libs/jquery/jquery.cache2.js" type="text/javascript"></script>
<script language="javascript" src="<?php echo HTTPROOT; ?>/assets/js/script.js"></script>
<?php if($globalPluginJs) { ?>
	<?php foreach($globalPluginJs as $jsFile) { ?>
		<script language="javascript" src="<?php echo $jsFile; ?>"></script>
	<?php } ?>
<?php } ?>
<?php if($globalPluginCss) { ?>
	<?php foreach($globalPluginCss as $cssFile) { ?>
		<link href="<?php echo $cssFile; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
<?php } ?>
<?php if($_GET['initialUrl']) { ?>
<script language="javascript">
	window.onload = function() {
		doAjaxLoadingText('<?php echo urldecode($_GET['initialUrl']); ?>','GET','<?php echo $_SERVER['QUERY_STRING']; ?>','','center','yes','',0);
	}
</script>
<?php } ?>
<!-- InstanceBeginEditable name="head" -->
<script src="<?php echo HTTPROOT; ?>/libs/jquery/jquery.timePicker.js" type="text/javascript"></script>
<link href="<?php echo HTTPROOT; ?>/libs/jquery/jquery.timePicker.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
</head>
<?php flush(); ?>

<body>
<div id="mainContent">
	<div id="head"></div>
	<div id="header"><a href="<?php echo HTTPROOT; ?>"><img src="<?php echo HTTPROOT; ?>/assets/images/mumbaionline_org_in.jpg" border="0" /></a></div>
	<div style="clear:both"></div>
	<div id="middle">
		<div id="left">
		<?php include(DOCROOT.'/assets/xtras/menu.php'); ?>
		</div>
		<div id="center">	
<!-- InstanceBeginEditable name="EditRegion3" -->
<h1>Add New Reminder</h1>
<form name="form1" method="post" action="">
<table border="0">
  <tr>
    <td align="right" valign="top"><strong>Title:*</strong></td>
    <td valign="top"><input name="title" type="text" id="title" size="45"></td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>Message:*</strong></td>
    <td valign="top"><textarea name="message" cols="35" rows="2" id="message"></textarea></td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>To Phone Numbers:*
    </strong></td>
    <td valign="top"><input name="tophone" type="text" id="tophone" value="" size="35" />
      <strong>Seperated By Comma</strong></td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>SMS Type:</strong></td>
    <td valign="top"><select name="smstype" id="smstype">
<option value="Fixed" selected>Fixed</option>
<option value="Recurring">Recurring</option>

    </select>&nbsp;</td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>SMS Date:* </strong></td>
    <td valign="top"><input name="smsdatetime" type="text" id="smsdatetime"></td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>SMS Time:* </strong></td>
    <td valign="top"><input name="smstime" type="text" id="smstime" size="12" /></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Recurring Type: </strong></td>
    <td valign="top"><select name="recurringtype" id="recurringtype">
      <option value="">No Recurring</option>
      <option value="Every 10 Minutes">Every 10 Minutes</option>
      <option value="Every Half Hourly">Every Half Hourly</option>
      <option value="Hourly">Hourly</option>
      <option value="Every 2 Hour">Every 2 Hour</option>
      <option value="Every 3 Hours">Every 3 Hours</option>
      <option value="Every 6 Hours">Every 6 Hours</option>
      <option value="Daily">Daily</option>
      <option value="WeekDays">WeekDays</option>
      <option value="Sunday">Sunday</option>
      <option value="SatSun">SatSun</option>
      <option value="Fortnight">Fortnight</option>
      <option value="Monthly">Monthly</option>
      <option value="Quarterly">Quarterly</option>
      <option value="SixMonthly">SixMonthly</option>
      <option value="Yearly">Yearly</option>
    </select></td>
    </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td valign="top"><div id="sms_new_message"></div>
	<input type="button" name="Submit" value="Create New Reminder" onclick="str=getFormElements(this.form); doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/sms/new_submit.php','POST','', str, 'sms_new_message', 'yes', '', '0');">
	<input name="senddatetime" type="hidden" id="senddatetime" />
	<input name="created" type="hidden" id="created" value="<?php echo date('Y-m-d H:i:s'); ?>" />
	<input name="status" type="hidden" id="status" value="1" />
	<input name="MM_Insert" type="hidden" id="MM_Insert" value="1" /></td>
    </tr>
</table>
</form>
<script language="javascript">
	jQuery(function($){
		$("#smsdatetime").datepicker();
		$("#smstime").timePicker();
	});
	
</script>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="footer" align="center">
		<?php include_once(DOCROOT.'/end.php'); ?>
	</div>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</body>
<!-- InstanceEnd --></html>
