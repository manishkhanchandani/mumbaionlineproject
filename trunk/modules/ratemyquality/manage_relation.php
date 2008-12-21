<?php require_once('../../Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
?>
<?php
if($_POST['MM_Insert']==1) {
	include_once('Classes/ratequality.php');
	$ratequality = new ratequality($dbFrameWork);
	$msg = $ratequality->updateRelation($_POST);
	$url = HTTPROOT."/modules/ratemyquality/manage_profile.php";
	header("Location: ".HTTPROOT."/index.php?msg=".urlencode($msg)."&initialUrl=".urlencode($url));
	exit;
}
?>
<?php
$colname_rsView = "-1";
if (isset($_GET['id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities WHERE id = %s", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);

$colname_rsQualities = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsQualities = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsQualities = sprintf("SELECT * FROM rate_my_qualities_question WHERE user_id = %s", $colname_rsQualities);
$rsQualities = mysql_query($query_rsQualities, $conn) or die(mysql_error());
$row_rsQualities = mysql_fetch_assoc($rsQualities);
$totalRows_rsQualities = mysql_num_rows($rsQualities);

$colname_rsRelation = "-1";
if (isset($_GET['id'])) {
  $colname_rsRelation = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsRelation = sprintf("SELECT * FROM rate_my_qualities_relation WHERE id = %s", $colname_rsRelation);
$rsRelation = mysql_query($query_rsRelation, $conn) or die(mysql_error());
$row_rsRelation = mysql_fetch_assoc($rsRelation);
$totalRows_rsRelation = mysql_num_rows($rsRelation);
?>
<h1>Choose Quality for Profile &quot;<?php echo $row_rsView['name']; ?>&quot;</h1>
<?php include(DOCROOT."/modules/ratemyquality/menu.php"); ?>
<?php if ($totalRows_rsRelation > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <?php $rel[] = $row_rsRelation['qid']; ?>
    <?php } while ($row_rsRelation = mysql_fetch_assoc($rsRelation)); ?>
  <?php } // Show if recordset not empty ?>
  
  <?php if ($totalRows_rsQualities > 0) { // Show if recordset not empty ?>
    <form id="form1" name="form1" method="post" action="<?php echo HTTPROOT."/modules/ratemyquality/manage_relation.php"; ?>">
      <p>
        <?php do { ?>
		<input type="checkbox" name="qid[]" value="<?php echo $row_rsQualities['qid']; ?>" <?php if($rel) { if(in_array($row_rsQualities['qid'],$rel)) { ?>checked="checked"<?php } } ?> />
		<?php echo $row_rsQualities['quality']; ?>
		<?php } while ($row_rsQualities = mysql_fetch_assoc($rsQualities)); ?>
      </p>
      <p>
        <input type="submit" name="Submit" value="Update Qualities" />
        <input name="MM_Insert" type="hidden" id="MM_Insert" value="1" />
        <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" />
      </p>
    </form>
    <p>&nbsp;</p>
    <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsQualities == 0) { // Show if recordset empty ?>
  <p>No Quality Found. </p>
  <?php } // Show if recordset empty ?>
<?php
mysql_free_result($rsView);

mysql_free_result($rsQualities);

mysql_free_result($rsRelation);
?>
