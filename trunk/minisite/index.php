<?php require_once('../Connections/conn.php'); ?>
<?php 
include_once('start.php');
$j = md5($_SERVER['REQUEST_URI']);
if(!$_GET['id']) $_GET['id'] = rand(1,150000);
?>
<?php
$colname_rsKeyword = "-1";
if (isset($_GET['id'])) {
  $colname_rsKeyword = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
$query_rsKeyword = sprintf("SELECT * FROM cg_short_keywords WHERE keyword_id = %s", $colname_rsKeyword);
$rsKeyword = $dbFrameWork->CacheExecute(10000, $query_rsKeyword);
$row_rsKeyword = $rsKeyword->FetchRow();
?>
<?php
switch($_GET['action']) {
	case 'search':
	
		break;
	case 'news':
	default:
		$result = checkcache($j);
		if(!$result) {
			include_once('Classes/simplepie.php');
			$simplepie = new SimplePie;
			$url = 'http://www.google.com/news?sourceid=navclient-ff&rlz=1B3GGGL_enIN279IN280&hl=en&ned=us&q='.urlencode($row_rsKeyword['keyword']).'&ie=UTF-8&nolr=1&output=rss';
			$simplepie->set_feed_url($url);
			$simplepie->init();
			$dig_feed = $simplepie;
			if($dig_feed) {
				$result = "<ul>";
				foreach($dig_feed->get_items() as $item) {
					$result .= "<li><a href='" .$item->get_link() . "' target='_blank'>" . $item->get_title() . "</a><br />";
					$desc = str_replace("<a ", "<a target='_blank' ", $item->get_description());
					$result .= $desc."
					</li>";
				}
				$result .= "</ul>";
			} else {
				$result = "<p>No Record Found.</p>";
			}
			cachefunction($j, $result);
			$cache = 'no cache';
		}	else {
			$cache = 'cache';
		}
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Mumbaionline.org.in :: <?php echo ucwords($row_rsKeyword['keyword'])." :: ".ucwords($_GET['action']); ?></title>
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
	<?php if($_GET['action']=="search") { ?>
	<script src="http://www.google.com/jsapi?key=ABQIAAAALUsWUxJrv3zXUNCu0Kas1RSrRvF9Qgn25y1kT-Pt-mhWLPO2YxSKtc1Vkd3dw5VoaVR0_k541txmtQ" type="text/javascript"></script>
    <script language="Javascript" type="text/javascript">
    //<![CDATA[

    google.load("search", "1");

    function OnLoad() {
      // Create a search control
      var searchControl = new google.search.SearchControl();

      // Add in a full set of searchers
      var localSearch = new google.search.LocalSearch();
      searchControl.addSearcher(localSearch);
      searchControl.addSearcher(new google.search.WebSearch());
      searchControl.addSearcher(new google.search.VideoSearch());
      searchControl.addSearcher(new google.search.BlogSearch());

      // Set the Local Search center point
      localSearch.setCenterPoint("New York, NY");

      // Tell the searcher to draw itself and tell it where to attach
      searchControl.draw(document.getElementById("searchcontrol"));

      // Execute an inital search
      searchControl.execute("<?php echo urlencode($row_rsKeyword['keyword']); ?>");
    }
    google.setOnLoadCallback(OnLoad);

    //]]>
    </script>
	<?php } ?>
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
<h1><?php echo ucwords($row_rsKeyword['keyword'])." :: ".ucwords($_GET['action']); ?></h1>
<?php include(DOCROOT.'/minisite/menu.php'); ?>
<?php if($_GET['action']=="search") { ?>
<div id="searchcontrol">Loading...</div>
<?php } else { ?>
<?php echo $result; ?>
<!-- #BeginLibraryItem "/Library/endtime.lbi" -->
<?php
$TIMEEND = microtime(true);
$time = $TIMEEND - $TIMESTART;

echo "<br /><br /><br /><br /><div align='right'><b>Time To Load:</b> $time seconds ($cache)</div>";
?>
<!-- #EndLibraryItem -->
<?php } ?>
<?php 
$query = sprintf("UPDATE cg_short_keywords set `views`=`views`+1 WHERE keyword_id = %s", $_GET['id']);
$rs = $dbFrameWork->Execute($query);
?>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="footer" align="center">
	  <p>Copyright &copy; 2008-2009 <a href="<?php echo $base; ?>">Mumbaionline.org.in</a> </p>
	  <p>This site is made using php, mysql, adodb, pear, jquery functionalities<br />
      This site is designed and developed by only one technical lead developer: <a href="mailto:mkgxy@mkgalaxy.com">Manish Khanchandani</a></p>
<?php include_once(DOCROOT.'/end.php'); ?>

	</div>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</body>
<!-- InstanceEnd --></html>
