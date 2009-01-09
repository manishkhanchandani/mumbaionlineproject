<?php 
	header("Content-type: text/xml");
	include_once("admin/config.php");
	include_once('inc_dbcon.php');
	require_once($languageFile);
?>
<rss version="2.0"  xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title><?php echo $rss_title;?></title>
    <link><?php echo $urlPath;?>/</link>
    <description><?php echo $rss_description;?></description>
    <language>en-us</language>
    <pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>
    <lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>
    <docs><?php echo $urlPath;?>/rss.php</docs>
    <generator>PHP</generator>
    <managingEditor><?php echo $urlPath;?></managingEditor>
    <webMaster><?php echo $urlPath;?></webMaster>
<?php 

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
	$category = $_GET["category"];

$type = "%";
if (isset($_GET["type"]))
	$type = $_GET["type"];

if (isset($_GET["msg"]))
	$msg = $_GET["msg"];

$maxRows_Recordset1 = 100;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = "SELECT postId,category,title,description,type,isAvailable,description,price,confirmPassword,category,imgURL,imgURLThumb,DATE_FORMAT(timeStamp,'%b %d, %Y %l:%i %p') AS timeStamp1 FROM md_postings WHERE isConfirmed = '1' AND category like '$category' AND type like '$type' ORDER BY `timeStamp` DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1);
	if (!$Recordset1){    
		print("It appears we have a problem: " . mysql_error());    
		exit();  
	}
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
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
if($totalRows_Recordset1 < 1)
{
	echo "<br />" . STR_NOITEMS;	
} else {
 	do { 
		 $type = $row_Recordset1['type'];
		 $isAvailable = $row_Recordset1['isAvailable'];
		 $isAvailableClass = ($isAvailable == 0) ? 'md_taken' : ''; 
		print("<item> \n");
	 	print("  <title>" . str_replace ( "&", "&amp;", $row_Recordset1['title'] ). "   (" .  $row_Recordset1['category']   ." / " . $row_Recordset1['type'] . ")</title> \n");
	 	print("  <link>" . $urlPath . "/viewItem.php?id=" . $row_Recordset1['postId'] . "</link> \n");
	 	print("  <description>" . str_replace ( "&", "&amp;", $row_Recordset1['description']) . "</description> \n");
		print("  <pubDate>" . $row_Recordset1['timeStamp1'] . "</pubDate> \n");
	 	print("</item>\n ");
	 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
} // end else clause
?>
 </channel>
</rss>
<?php 
	mysql_free_result($Recordset1); 
	mysql_close($dbConn);
?>