<?php
include_once('start.php');
if(!$_GET['initialUrl'])
$_GET['initialUrl'] = "home.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>MumbaiOnline.Org.In</title>
<!-- InstanceEndEditable -->
<script type="text/javascript">
var HTTPROOT = "<?php echo HTTPROOT; ?>";
</script>
<link href="assets/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="libs/jquery/jquery-1.2.6.js"></script>
<!-- Menu System -->
<link rel="stylesheet" href="libs/jquery/treeview/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo $base; ?>libs/jquery/treeview/screen.css" />

<script src="libs/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="libs/jquery/treeview/jquery.treeview.js" type="text/javascript"></script>

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
<link rel="stylesheet" href="libs/core.ui.datepicker/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="libs/core.ui.datepicker/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<!-- datepicker ends -->
<script src="libs/jquery/jquery.cache2.js" type="text/javascript"></script>
<script language="javascript" src="assets/js/script.js"></script>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<?php flush(); ?>

<body>
<div id="mainContent">
	<div id="head"></div>
	<div id="header"><img src="assets/images/mumbaionline_org_in.jpg" /></div>
	<div style="clear:both"></div>
	<div id="middle">
		<div id="left">
		<?php include('assets/xtras/menu.php'); ?>
		</div>
		<div id="center">	
<!-- InstanceBeginEditable name="EditRegion3" -->
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="footer" align="center">
	  <p>Copyright &copy; 2008-2009 <a href="<?php echo $base; ?>">Mumbaionline.org.in</a> </p>
	  <p>This site is made using php, mysql, adodb, pear, jquery functionalities<br />
      This site is designed and developed by only one technical lead developer: <a href="mailto:mkgxy@mkgalaxy.com">Manish Khanchandani</a></p>
	</div>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</body>
<!-- InstanceEnd --></html>