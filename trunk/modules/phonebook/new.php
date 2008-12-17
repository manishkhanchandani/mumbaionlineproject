<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
$initialUrl = urlencode($_SERVER['PHP_SELF']);
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
  $insertSQL = sprintf("INSERT INTO phonebook (user_id, name, phone, email, comments, `public`, created) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['public'], "int"),
                       GetSQLValueString($_POST['created'], "date"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = HTTPROOT."/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<h1>Add New Phone/Email Contact</h1>
<p><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/view.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/phonebook/view.php"); ?>', '1');">View My Contact</a></p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap>Name:</td>
      <td class="td" valign="top"><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap>Phone:</td>
      <td class="td" valign="top"><input type="text" name="phone" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap>Email:</td>
      <td class="td" valign="top"><input type="text" name="email" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td class="th" nowrap align="right" valign="top">Comments:</td>
      <td class="td" valign="top"><textarea name="comments" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap>Contact Type :</td>
      <td class="td" valign="top"><table>
        <tr>
          <td><input name="public" type="radio" value="1" checked="checked" >
            Public</td>
          <td><input name="public" type="radio" value="0" checked="checked" /> 
            Private
</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td class="th" align="right" valign="top" nowrap>&nbsp;</td>
      <td class="td" valign="top"><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
  <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s'); ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
