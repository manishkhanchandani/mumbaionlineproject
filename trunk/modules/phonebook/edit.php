<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE phonebook SET name=%s, phone=%s, email=%s, comments=%s, `public`=%s WHERE phonebook_id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['public'], "int"),
                       GetSQLValueString($_POST['phonebook_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = HTTPROOT."/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsEdit = "-1";
if (isset($_GET['phonebook_id'])) {
  $colname_rsEdit = (get_magic_quotes_gpc()) ? $_GET['phonebook_id'] : addslashes($_GET['phonebook_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsEdit = sprintf("SELECT * FROM phonebook WHERE phonebook_id = %s", $colname_rsEdit);
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?>
<?php
if($_COOKIE['user_id']!=$row_rsEdit['user_id']) {
	echo '<p class="error">You are not allowed to edit this record.</p>';
	exit;
}
?>
<h1>Edit Phone/Email Contact</h1>
<p><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/new.php','GET','initialUrl=<?php echo HTTPROOT; ?>/modules/phonebook/view.php', '', 'center', 'yes', '<?php echo md5("modules/phonebook/new.php"); ?>', '1');">Add New Contact</a> | <a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/view.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/phonebook/view.php"); ?>', '1');">View My Contact</a></p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap="nowrap">Name:</td>
      <td class="td" valign="top"><input type="text" name="name" value="<?php echo $row_rsEdit['name']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap="nowrap">Phone:</td>
      <td class="td" valign="top"><input type="text" name="phone" value="<?php echo $row_rsEdit['phone']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap="nowrap">Email:</td>
      <td class="td" valign="top"><input type="text" name="email" value="<?php echo $row_rsEdit['email']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td class="th" nowrap="nowrap" align="right" valign="top">Comments:</td>
      <td class="td" valign="top"><textarea name="comments" cols="50" rows="5"><?php echo $row_rsEdit['comments']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap="nowrap">Contact Type :</td>
      <td class="td" valign="top"><table>
          <tr>
            <td><input <?php if (!(strcmp($row_rsEdit['public'],"1"))) {echo "checked=\"checked\"";} ?> name="public" type="radio" value="1">
              Public</td>
            <td><input <?php if (!(strcmp($row_rsEdit['public'],"0"))) {echo "checked=\"checked\"";} ?> name="public" type="radio" value="0" />
              Private </td>
          </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap="nowrap">&nbsp;</td>
      <td class="td" valign="top"><input name="submit" type="submit" value="Update" /></td>
    </tr>
  </table>
  <input name="phonebook_id" type="hidden" id="phonebook_id" value="<?php echo $row_rsEdit['phonebook_id']; ?>" />
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($rsEdit);
?>
