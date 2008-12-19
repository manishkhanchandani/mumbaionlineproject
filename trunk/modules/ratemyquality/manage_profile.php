<?php require_once('../../Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(!trim($_POST['name'])) {
		unset($_POST["MM_insert"]);
		$msg = "<p class='error'>Please fill the name.</p>";
	}
	$_POST['photo'] = $_FILES['image']['name'];
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
  $insertSQL = sprintf("INSERT INTO rate_my_qualities (user_id, name, photo) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['photo'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}


if ($_POST["MM_insert"] == "form1") {
	$id = mysql_insert_id();
	if($_FILES) {
		$dir = dirname(__FILE__)."/images/";
		$filename = $id."_".$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], $dir.$filename);
	}
	$msg = "<p class='error'>Profile Created Successfully.</p>";
}

$colname_rsView = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities WHERE user_id = %s ORDER BY name ASC", $colname_rsView);
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
<h1>Add New Profile</h1>
<?php echo $msg; ?>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Photo:</td>
      <td><input name="image" type="file" id="image" size="45" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Add New Profile"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
  <input type="hidden" name="photo" value="">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h1>View Profile </h1>
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <td>Name</td>
      <td>Add Qualities </td>
      <td>Send Link To Friend </td>
      <td>View Rating </td>
      <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_rsView['name']; ?></td>
        <td><a href="manage_relation.php?id=<?php echo $row_rsView['id']; ?>">Add Qualities</a></td>
        <td><a href="#">Send Link To Friend </a></td>
        <td><a href="#">View Rating</a></td>
        <td><a href="#">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
      </table>
  <?php } // Show if recordset not empty ?></body>
</html>
<?php
mysql_free_result($rsView);
?>
