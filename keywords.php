<?php
include_once('start.php');
include('Classes/PaginateIt.php');
if($_GET['page']) $_GET['pageNum_rsKeywords'] = $_GET['page']-1;

$maxRows_rsKeywords = 100;
$pageNum_rsKeywords = 0;
if (isset($_GET['pageNum_rsKeywords'])) {
  $pageNum_rsKeywords = $_GET['pageNum_rsKeywords'];
}

$query_rsKeywords = "SELECT keyword_id, keyword, kw_url_lookup FROM cg_short_keywords WHERE keyword is NOT NULL AND keyword != ''";
if($_GET['q']) {
	$query_rsKeywords .= " AND keyword LIKE '".$_GET['q']."%'";
	$query_rsKeywords .= "  ORDER BY keyword ASC";
	$maxRows_rsKeywords = 100;
	$pageTitle = "Minisite List :: Search Keyword :: ".$_GET['q']." Mumbai";
	$_GET['totalRows_rsKeywords'] = 100;
} else if($_GET['kw']) {
	$query_rsKeywords = "SELECT keyword_id, keyword, kw_url_lookup, MATCH(keyword) AGAINST('+".$_GET['kw']."' IN BOOLEAN MODE) as m FROM cg_short_keywords WHERE keyword is NOT NULL AND keyword != ''";
	$query_rsKeywords .= " AND MATCH(keyword) AGAINST('+".$_GET['kw']."' IN BOOLEAN MODE)";
	$query_rsKeywords .= "  ORDER BY m DESC";
	$maxRows_rsKeywords = 100;
	$pageTitle = "Minisite List :: Search Keyword :: ".$_GET['kw']." Mumbai";
	$_GET['totalRows_rsKeywords'] = 100;
} else {
	$sql = "select seq from tbl_seq where tablename = 'cg_short_keywords'";
	$rs = $dbFrameWork->CacheExecute(3000, $sql);
	$row = $rs->FetchRow();
	$_GET['totalRows_rsKeywords'] = $row['seq'];
	$pageTitle = "Minisite List :: Search Keyword :: Complete Mumbai";
	$query_rsKeywords .= "  ORDER BY RAND()";
}
if($_GET['page']) $pageTitle .= " :: Page - ".$_GET['page'];
$startRow_rsKeywords = $pageNum_rsKeywords * $maxRows_rsKeywords;

$rsKeywords = $dbFrameWork->CacheSelectLimit(10000, $query_rsKeywords, $maxRows_rsKeywords, $startRow_rsKeywords);

if (isset($_GET['totalRows_rsKeywords'])) {
  $totalRows_rsKeywords = $_GET['totalRows_rsKeywords'];
  if(!$rsKeywords->FetchRow()) {
  	if($_GET['kw']) {
		$row = $_GET['kw'];
		$makeurl = $common->make_url_lookup($row);
  		$sql = "insert into cg_short_keywords set keyword = '".addslashes(stripslashes(trim($row)))."', kw_url_lookup = '".$makeurl."', created_on = '".date('Y-m-d H:i:s')."', ip = '".addslashes(stripslashes(trim($_SERVER['REMOTE_ADDR'])))."'";
		$dbFrameWork->Execute($sql);
		$insertId = $dbFrameWork->Insert_ID();
		$sql = "update tbl_seq set `seq` = `seq` + 1 WHERE tablename = 'cg_short_keywords'";
		$dbFrameWork->Execute($sql);
		header("Location: ".HTTPROOT."/minisite/".($insertId)."/news/".$makeurl.".".EXTENSION);
		exit;
	}
  }
} else {
  $totalRows_rsKeywords = 10;
}
$totalPages_rsKeywords = ceil($totalRows_rsKeywords/$maxRows_rsKeywords)-1;
?>
<?php
$PaginateIt = new PaginateIt();
$PaginateIt->SetCurrentPage(($pageNum_rsKeywords+1));
$PaginateIt->SetItemsPerPage($maxRows_rsKeywords);
$PaginateIt->SetItemCount($totalRows_rsKeywords);
$paginate = $PaginateIt->GetPageLinks_Old();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $pageTitle; ?></title>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
<h1>MiniSite</h1>
<p><?php 
for($i=65;$i<=90;$i++) {
	echo "<a href='keywords.php?q=".chr($i)."'>".chr($i)."</a> ";
}
echo "<a href='keywords.php'>All</a> ";
?>
</p>
<form name="searchKw" action="" method="get">
	<input type="text" name="kw" value="<?php echo $_GET['kw']; ?>" />
	<input type="submit" name="Submit" value="Search Keyword" />
    <br />
    <br />
</form>
<?php if($totalRows_rsKeywords>0) { ?>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tr class="th">
    <td>MiniSite</td>
    </tr>
  <?php while ($row_rsKeywords = $rsKeywords->FetchRow()) { ?>
    <tr class="td">
      <td><a href="<?php echo HTTPROOT; ?>/minisite/<?php echo $row_rsKeywords['keyword_id']; ?>/news/<?php echo $row_rsKeywords['kw_url_lookup']; ?>.<?php echo EXTENSION; ?>"><?php echo $row_rsKeywords['keyword']; ?></a></td>
      </tr>
    <?php } ?>
</table>
<?php if($totalPages_rsKeywords>0) { ?>
<p><?php echo $paginate; ?></p>
<?php } ?>
<?php } else { ?>
<p class="error">No Site Found.</p>
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
