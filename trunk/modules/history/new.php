<?php require_once('../../Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo 'Please login first.';
	exit;
}
if ($_POST["MM_insert"] == "form1") {
	if(!$_POST['history_date']) {
		$msg .= "Please enter date. ";
		unset($_POST["MM_insert"]);
	}
	if(!$_POST['history_title']) {
		$msg .= "Please enter title. ";
		unset($_POST["MM_insert"]);
	}
	if(!$_POST['history_detail']) {
		$msg .= "Please enter detail. ";
		unset($_POST["MM_insert"]);
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
  $insertSQL = sprintf("INSERT INTO history (user_id, history_date, history_title, history_detail, `public`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['history_date'], "date"),
                       GetSQLValueString($_POST['history_title'], "text"),
                       GetSQLValueString($_POST['history_detail'], "text"),
                       GetSQLValueString($_POST['public'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ($_POST["MM_insert"] == "form1") {
	$msg = "History added successfully.";
	unset($_POST);
}
?>
<h1>Add New History</h1>
<?php if($msg) { ?>
<p class="error"><?php echo $msg; ?></p>
<?php } ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Date:</td>
      <td><input type="text" name="history_date" id="history_date" value="<?php echo $_POST['history_date']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Title:</td>
      <td><input type="text" name="history_title" value="<?php echo $_POST['history_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Details</td>
      <td><textarea name="history_detail" cols="50" rows="5"><?php echo $_POST['history_detail']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td><input name="public" type="radio" value="Y" checked>
        Public 
        <input name="public" type="radio" value="N">
        Private</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insert record" onclick="str=getFormElements(this.form); newHistory('', 'POST', str, '0');"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>