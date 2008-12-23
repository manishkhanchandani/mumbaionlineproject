<?php require_once('../../Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
if($_GET['deleteprofileid']) {
	include_once('Classes/ratequality.php');
	$ratequality = new ratequality($dbFrameWork);
	$ratequality->deleteProfile($_GET['deleteprofileid']);
}
?>
<?php
$colname_rsView = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities WHERE user_id = %s ORDER BY name ASC", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);
?>
<h1>Add New Profile</h1>
<?php include(DOCROOT."/modules/ratemyquality/menu.php"); ?>
<?php echo stripslashes($_GET['msg']); ?>
<form action="<?php echo HTTPROOT."/modules/ratemyquality/profile_add.php"; ?>" method="post" enctype="multipart/form-data" name="form1">
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
      <td>Voting Results </td>
      <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_rsView['name']; ?></td>
        <td><a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_relation.php','GET','id=<?php echo $row_rsView['id']; ?>', '', 'center', 'yes', '', '0');">Add Qualities</a></td>
        <td><a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/sendlink.php','GET','id=<?php echo $row_rsView['id']; ?>', '', 'center', 'yes', '<?php echo md5('/modules/ratemyquality/sendlink.php?id='.$row_rsView['id']); ?>', '1');">Send Link To Friend </a></td>
        <td><a href="<?php echo HTTPROOT; ?>/modules/ratemyquality/index.php?id=<?php echo $row_rsView['id']; ?>" target="_blank">View Rating</a></td>
        <td><a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/view_voting.php','GET','id=<?php echo $row_rsView['id']; ?>', '', 'center', 'yes', '<?php echo md5('/modules/ratemyquality/view_voting.php?id='.$row_rsView['id']); ?>', '1');">Voting Results</a></td>
        <td><a href="#" onClick="if(confirmDelete('Are you sure you want to delete this profile?')) doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_profile.php','GET','deleteprofileid=<?php echo $row_rsView['id']; ?>', '', 'center', 'yes', '', '0');">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
      </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsView);
?>
