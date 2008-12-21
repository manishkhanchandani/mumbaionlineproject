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
if($_GET['did']) {
	include_once('Classes/ratequality.php');
	$ratequality = new ratequality($dbFrameWork);
	$ratequality->deleteQuality($_GET['did']);
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

$colname_rsView = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities_question WHERE user_id = %s ORDER BY quality ASC", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);
?>
<h1>Add Quality</h1>
<?php include(DOCROOT."/modules/ratemyquality/menu.php"); ?>
<?php echo $msg; ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr valign="baseline">
      <td nowrap align="right" class="th">Quality:</td>
      <td class="td"><input type="text" name="quality" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" class="th">&nbsp;</td>
      <td class="td"><input type="button" value="Insert record" onclick="str=getFormElements(this.form); doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_qualities.php','POST','', str, 'center', 'yes', '', '0');"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
<p><strong>Example of some of qualities are:</strong><br />
Acceptance . . . Assertiveness . . . Balance . . . Beauty . . . Carefulness

Clarity . . . Compassion . . . Confidence . . . Courage . . . Creativity

Curiosity . . . Energy . . . Enthusiasm . . . Faith . . . Flexibility . . . Forgiveness

Fortitude . . . Freedom . . . Generosity . . . Gentleness . . . Grace . . . Gratitude

Harmony . . . Hope . . . Humility . . . Integrity . . . Joy . . . Kindness . . . Learning

Love . . . Morality . . . Nurturance . . . Objectivity . . . Openness . . . Optimism

Passion . . . Patience . . . Peace . . . Persistence . . . Playfulness

Purpose . . . Resilience . . . Serenity . . . Simplicity . . . Spirituality . . . Stability

Steadfastness . . . Strength . . . Tenderness . . . Tolerance . . . Vitality<br>
Other examples are: 1. Loving
2. Patience
3. Listens
4. Caring
5. Humor
6. Peacefulness
7. Honesty
8. Humility
9. Joyful
10. Faith in something... whatever it is for them that they can believe in<br>
Other examples are: 1) Loyalty 2) Empathy 3) Compassion 4) Open-mindedness 5) Honesty 6) Tolerance</p>
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
        <td><a href="#" onClick="if(confirmDelete('Are you sure you want to delete this quality?')) doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_qualities.php','GET','did=<?php echo $row_rsView['qid']; ?>', '', 'center', 'yes', '', '0');">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsView);
?>