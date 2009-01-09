<?php 
include_once('start.php');
include_once('inc_dbcon.php'); 
require_once('admin/config.php');
require_once($languageFile);
if($_GET['category']) {
	$sql = "SELECT * FROM md_categories WHERE cat_id = '".$_GET['category']."' order by cat_order";
	$rs = $dbFrameWork->CacheExecute(5000, $sql);
	$rec = $rs->FetchRow();
	$catName = "Category :: ".$rec['cat_name'];
	$pageTitle = "Mumbaionline.org.in :: ".$catName;
} else if($_GET['a']) {
	$catName = "All Category";
	$pageTitle = "Mumbaionline.org.in :: ".$catName;
} else {
	$catName = "Classifieds";
	$pageTitle = "Mumbaionline.org.in :: ".$catName;
}
// check to see if in admin mode and validate key
global $keyOut;
$keyOut = "";
if (isset($_GET["k"]))
	if($_GET["k"] == $key){ // Key comes from admin/password.php file
		$keyOut = "&k=" . $key;
	}
		
global $category;
$category = "%";
if (isset($_GET["category"]))
	$category = mysql_real_escape_string($_GET["category"]);

$type = "%";
if (isset($_GET["type"]))
	$type = mysql_real_escape_string($_GET["type"]);

if (isset($_GET["msg"]))
	$msg = mysql_real_escape_string($_GET["msg"]);

// SEARCH CODE START
$searchQuery = "";
if (isset($_GET["q"]))
	$searchQuery = mysql_real_escape_string($_GET["q"]);

if ($searchQuery != "") 
{
	$query_Recordset1 = "SELECT postId,category,title,description,type,isAvailable,description,price,confirmPassword,category,imgURL,imgURLThumb,DATE_FORMAT(timeStamp,'%b %d, %Y %l:%i %p') AS timeStamp1 FROM md_postings WHERE isConfirmed = '1' AND title like '%$searchQuery%' OR description like '%searchQuery%' ORDER BY `timeStamp` DESC";	
	$query_Recordset2 = "SELECT count(*) as cnt FROM md_postings WHERE isConfirmed = '1' AND title like '%$searchQuery%' OR description like '%searchQuery%' ORDER BY `timeStamp` DESC";
} else {
	// this following line was pulled from about ten lines below if you are updating an older version
	$query_Recordset1 = "SELECT postId,category,title,description,type,isAvailable,description,price,confirmPassword,category,imgURL,imgURLThumb,DATE_FORMAT(timeStamp,'%b %d, %Y %l:%i %p') AS timeStamp1 FROM md_postings WHERE isConfirmed = '1' AND category like '$category' AND type like '$type' ORDER BY `timeStamp` DESC";
	$query_Recordset2 = "SELECT count(*) as cnt FROM md_postings WHERE isConfirmed = '1' AND category like '$category' AND type like '$type' ORDER BY `timeStamp` DESC";
}
// SEARCH CODE END - see also line 113 below

$maxRows_Recordset1 = 100;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = mysql_real_escape_string($_GET['pageNum_Recordset1']);
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
/*
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1);
	if (!$Recordset1){    
		print("It appears we have a problem: " . mysql_error());    
		exit();  
	}
*/
$Recordset1 = $dbFrameWork->CacheSelectLimit(300, $query_Recordset1, $maxRows_Recordset1, $startRow_Recordset1);
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = mysql_real_escape_string($_GET['totalRows_Recordset1']);
} else {
  //$all_Recordset1 = mysql_query($query_Recordset1);
  //$totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
  $tot = $dbFrameWork->CacheExecute(300, $query_Recordset2);
  $arr = $tot->FetchRow();
  $totalRows_Recordset1 = $arr['cnt'];
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);

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
<!-- InstanceBeginEditable name="head" -->


<link href="md_style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function doFilter(dis)
{
	window.location.href = "index.php?category=<?php echo $category ?>&type=" + dis.value + "<?php echo $keyOut;?>"
}	
</script>
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
<h1><?php echo $catName; ?></h1>
<div id="md_container">	
<div align='right' id="md_filter">
	<form name='form2' style='display:inline;' >
		<?php echo STR_SHOWADDS ?> 
		<select onChange='doFilter(this)'>
			<option  name='type' value='%' <?php if($type == "%") echo " selected "; ?>>Both</option>
			<option name='type'   value='Need' <?php if($type == "Need") echo " selected "; ?>>Needs Only</option>
			<option name='type' value='Offering' <?php if($type == "Offering") echo " selected "; ?>>Offerings Only</option>	
		</select>
	</form>
</div>
<?php 
	if ($msg == "deleted")	
		print("<div class='md_msg' style='margin-top:-10px;'>" . STR_DELETED ."</div>"); 
?>
	
<div id='md_listingBox'>
<?php
if($totalRows_Recordset1 < 1)
{
	// SEARCH START new Code - added IF statement to support search
	if ($searchQuery != "")
		echo "<br />" . STR_NORESULTS . "<b>" . $searchQuery ."</b>";
	else
		echo "<br />" . STR_NOITEMS;
	// SEARCH END NEW CODE
} else {
 while ($row_Recordset1 = $Recordset1->FetchRow()) { 
  	 $img = "/images/gift_light.gif' title='This is a gift!'";
	 $type = $row_Recordset1['type'];
	 $isAvailable = $row_Recordset1['isAvailable'];
     $isAvailableClass = ($isAvailable == 0) ? 'md_taken' : ''; 
	 $thumbnail = '&nbsp;';
	 if (strlen($row_Recordset1['imgURLThumb']) > 3){
	 	$thumbnail = "<a href='viewItem.php?id=" . $row_Recordset1['postId'] . "' class='md_recordLink " . $isAvailableClass . "'>";
		$thumbnail .= "<img src='" . $row_Recordset1['imgURLThumb'] . "'></a>";
	}
?>
<table width="100%" border="0" cellpadding="4" class="md_listingTable">
  <tr>
    <td width="54" align="center"><?php echo $thumbnail; ?></td>
    <td valign="top">
    <div class='md_date'><?php echo $row_Recordset1['timeStamp1'];?></div> 
    <a href="viewItem.php?id=<?php echo $row_Recordset1['postId'] . $keyOut;?>" class='md_recordLink<?php echo $isAvailableClass; ?>'><?php echo $row_Recordset1['title']; ?></a> 
    &#8212; $<?php echo $row_Recordset1['price']; ?> 
    <div class='md_<?php echo $row_Recordset1['type']; ?>'><?php echo $row_Recordset1['type']; ?></div><br />
    <?php echo substr($row_Recordset1['description'],0,120); ?>...
    </td>
  </tr>
</table>
<?php } 
} // end else clause
?>

	</div>
</div>
<?php include_once("inc_footer.php");?>
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