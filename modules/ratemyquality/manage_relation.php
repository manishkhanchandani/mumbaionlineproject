<?php require_once('../../Connections/conn.php'); ?>
<?php
if($_POST['MM_Insert']==1) {
	$sql = "delete from rate_my_qualities_relation where id = '".$_GET['id']."'";
	mysql_query($sql) or die('error');
	if($_POST['qid']) {
		foreach($_POST['qid'] as $k=>$v) {
			$sql = "insert into rate_my_qualities_relation set qid = '".$v."', id = '".$_GET['id']."'";
			mysql_query($sql) or die('error');
		}
	}
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Choose Quality for Profile &quot;<?php echo $row_rsView['name']; ?>&quot;</h1>
<?php if ($totalRows_rsRelation > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <?php $rel[] = $row_rsRelation['qid']; ?>
    <?php } while ($row_rsRelation = mysql_fetch_assoc($rsRelation)); ?>
  <?php } // Show if recordset not empty ?><?php if ($totalRows_rsQualities > 0) { // Show if recordset not empty ?>
    <form id="form1" name="form1" method="post" action="">
      <p>
        <?php do { ?>
                <input type="checkbox" name="qid[]" value="<?php echo $row_rsQualities['qid']; ?>" <?php if($rel) { if(in_array($row_rsQualities['qid'],$rel)) { ?>checked="checked"<?php } } ?> />
                <?php echo $row_rsQualities['quality']; ?>
                <?php } while ($row_rsQualities = mysql_fetch_assoc($rsQualities)); ?>
      </p>
      <p>
        <input type="submit" name="Submit" value="Update Qualities" />
        <input name="MM_Insert" type="hidden" id="MM_Insert" value="1" />
      </p>
    </form>
    <p>&nbsp;</p>
    <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsQualities == 0) { // Show if recordset empty ?>
  <p>No Quality Found. </p>
  <?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($rsView);

mysql_free_result($rsQualities);

mysql_free_result($rsRelation);
?>
