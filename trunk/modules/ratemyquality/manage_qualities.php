<?php require_once('../../Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(!trim($_POST['quality'])) {
		unset($_POST["MM_insert"]);
		$msg = "<p class='error'>Please fill the quality name.</p>";
	}
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO rate_my_qualities_question (quality, user_id) VALUES (%s, %s)",
                       GetSQLValueString($_POST['quality'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['did'])) && ($_GET['did'] != "")) {
  $deleteSQL = sprintf("DELETE FROM rate_my_qualities_question WHERE qid=%s",
                       GetSQLValueString($_GET['did'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$colname_rsView = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities_question WHERE user_id = %s ORDER BY quality ASC", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Add Quality</h1>
<?php echo $msg; ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr valign="baseline">
      <td nowrap align="right" class="th">Quality:</td>
      <td class="td"><input type="text" name="quality" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" class="th">&nbsp;</td>
      <td class="td"><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h1>View My Qualities </h1>
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <td>Quality</td>
      <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_rsView['quality']; ?></td>
        <td><a href="manage_qualities.php?did=<?php echo $row_rsView['qid']; ?>">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
      </table>
  <?php } // Show if recordset not empty ?></body>
</html>
<?php
mysql_free_result($rsView);
?>
