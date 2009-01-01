<?php
include_once('start.php');

if(!$_GET['initialUrl']) {
	include_once('./Classes/simplepie.php');
	$simplepie = new SimplePie;
	// FUNCTIONALITY
	$j = md5($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
	$feed = checkcache($j);
	if(!$feed) {
		$url = $_GET['url'];
		if(!$url) 
			$url = 'http://www.google.com/news?sourceid=navclient-ff&rlz=1B3GGGL_enIN279IN280&hl=en&ned=us&q=mumbai&ie=UTF-8&nolr=1&output=rss';
		else 
			$url = urldecode($url);
		$simplepie->set_feed_url($url);
		$simplepie->init();
		$dig_feed = $simplepie;
		$feed = "<ul>";
		if($dig_feed) {
			foreach($dig_feed->get_items() as $item) {
				$feed .= "<li><a href='" .$item->get_link() . "' target='_blank'>" . $item->get_title() . "</a><br />";
				$desc = str_replace("<a ", "<a target='_blank' ", $item->get_description());
				$feed .= $desc."
				</li>";
			}
		}
		$feed .= "</ul>";
		cachefunction($j, $feed);
		$cache = 'no cache';
	} else {
		$cache = 'cache';
	}
	// FUNCTIONALITY
	$title2 = "New Year 2009";
	$j = md5($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."-".$title2);
	$feed2 = checkcache($j);
	if(!$feed2) {
		$keyword = urlencode($title2);
		$url2 = 'http://www.google.com/news?sourceid=navclient-ff&rlz=1B3GGGL_enIN279IN280&hl=en&ned=us&q='.$keyword.'&ie=UTF-8&nolr=1&output=rss';
		$simplepie->set_feed_url($url2);
		$simplepie->init();
		$dig_feed = $simplepie;
		$feed2 = "<ul>";
		if($dig_feed) {
			foreach($dig_feed->get_items() as $item) {
				$feed2 .= "<li><a href='" .$item->get_link() . "' target='_blank'>" . $item->get_title() . "</a><br />";
				$desc = str_replace("<a ", "<a target='_blank' ", $item->get_description());
				$feed2 .= $desc."
				</li>";
			}
		}
		$feed2 .= "</ul>";
		cachefunction($j, $feed2);
		$cache = 'no cache';
	} else {
		$cache = 'cache';
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>MumbaiOnline.Org.In :: Mumbai, Mumbai Online, All about Mumbai, My Mumbai, Know Mumbai</title>
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
<meta name="description" content="Mumbai, Mumbai Government, Mumbai Weather, Mumbai fun, Mumbai Guide, Complete guide Mumbai, Important Services in Mumbai, Emergency Services in Mumbai, Mumbai Services Information, Entertainment in Mumbai, Entertainment Centres in Mumbai, Mumbai News, History of Mumbai, Tourist places in Mumbai">
<meta name="keywords" content="Mumbai, Mumbai Online, All about Mumbai, My Mumbai, Know Mumbai, Mumbai fun, Mumbai Guide, Complete guide for Mumbai, Hospitals in Mumbai, Emergency Services in Mumbai, Mumbai Services Information, Entertainment in Mumbai, Entertainment in Mumbai, Mumbai News, Hotels in Mumbai, Restaurants in Mumbai, Movies in Mumbai, Bars in Mumbai, Mumbai Government, Mumbai Profile, Red Fort, Qutub Minar">
<meta name="language" content="English">
<meta name="author" content="Mumbaionline.org.in :: Manish Khanchandani">
<style type="text/css">
#centercolumn {

}
#centerleftcolumn {
border:thin solid red;
float:left;
margin-right:5px;
width:49%;
overflow:auto;
}
#centerrightcolumn {
border:thin solid blue;
float:left;
margin-right:5px;
width:49%;
overflow:auto;
}
</style>
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
<?php if(!$_GET['initialUrl']) { ?>
<div id="centercolumn">
	<div id="centerleftcolumn">
		<h3 align="center">Mumbai</h3>
		<?php 
			echo $feed;
		?>
	</div>
	<div id="centerrightcolumn">
		<h3 align="center"><?php echo $title2; ?></h3>
		<?php 
			echo $feed2;
		?>
	</div>
</div>
<div style="clear:both;"></div>
<!-- #BeginLibraryItem "/Library/endtime.lbi" --><?php
$TIMEEND = microtime(true);
$time = $TIMEEND - $TIMESTART;

echo "<br /><br /><br /><br /><div align='right'><b>Time To Load:</b> $time seconds ($cache)</div>";
?><!-- #EndLibraryItem -->
<?php } ?>
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
