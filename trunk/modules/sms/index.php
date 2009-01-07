<?php
include_once('start.php');
try {	
	// user access
	if(!$_COOKIE['user_id']) {
		throw new Exception('You are not logged on to the site');	
	}
	include_once('Classes/SMS.php');
	$SMS = new SMS;
	if($_GET['delId']) {
		// delete the record
		$common->deleteRecord('smsreminders', 'id', $_GET['delId']);
		$msg = "<p class='error'>Record Deleted</p>";
	}
	if($_GET['statusId']) {
		// update the record
		$ret['status'] = $_GET['status'];
		$common->editRecord('smsreminders', 'id', $ret, $_GET['statusId']);
		$msg = "<p class='error'>Record Updated</p>";
	}
	$initialUrl = urlencode($_SERVER['PHP_SELF']);
	include('Classes/PaginateIt.php');
	if($_GET['page']) $_GET['pageNum'] = $_GET['page']-1;
	
	$maxRows = 10;
	$pageNum = 0;
	if (isset($_GET['pageNum'])) {
	  $pageNum = $_GET['pageNum'];
	}
	$startRow = $pageNum * $maxRows;
	
	$colname = "-1";
	if (isset($_COOKIE['user_id'])) {
	  $colname = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
	}
	$query = sprintf("select count(*) as cnt from smsreminders WHERE user_id = %s and status = 1 ORDER BY senddate DESC", $colname);
	$rs = $dbFrameWork->Execute($query);
	if($dbFrameWork->ErrorMsg()) {
		throw new Exception($this->dbFrameWork->ErrorMsg());
	}
	$arr = $rs->FetchRow();
	$totalRows = $arr['cnt'];

	$query = sprintf("select * from smsreminders WHERE user_id = %s and status = 1 ORDER BY senddate DESC", $colname);
	$records = $common->selectLimitRecord($query, $maxRows, $startRow);

	if (isset($_GET['totalRows'])) {
	  $totalRows = $_GET['totalRows'];
	} else {
	  $all = mysql_query($query);
	  $totalRows = mysql_num_rows($all);
	}
	$totalPages = ceil($totalRows/$maxRows)-1;
	
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetCurrentPage(($pageNum+1));
	$PaginateIt->SetItemsPerPage($maxRows);
	$PaginateIt->SetItemCount($totalRows);
	$paginate = $PaginateIt->GetPageLinks();
} catch(Exception $e) {
	echo "<p class='error'>".$e->getMessage()."</p>";
	include('senderrortoadmin.php');
	exit;
}
?>
<h1>My Reminders</h1>
<?php echo $msg; ?>
<?php if(!$records) { ?>
<p>No Active Reminder Set.</p>
<?php } else  { ?>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tr class="th">
    <td valign="top">Title</td>
    <td valign="top">Details</td>
    <td valign="top">Dates:</td>
    <td valign="top">Type</td>
    <td valign="top">Actions</td>
  </tr>
	<?php foreach($records as $rec) { 
	?>
  <tr class="td">
    <td valign="top" bgcolor="#FFFFFF"><?php echo $rec['title']; ?>&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF"><strong>Message:</strong> <?php echo $rec['message']; ?> <br>
      <strong>Phone Number:</strong> <?php echo $rec['tophone']; ?></td>
    <td valign="top" bgcolor="#FFFFFF"><strong>Next Send Date:</strong> <?php if($rec['senddate']) { ?><?php echo date('d M, Y', $rec['senddate']); ?><br><?php echo date('h:i', $rec['senddate']); ?><?php } ?><br>
		<strong>Expected Send Date:</strong> <?php echo $rec['smsdatetime']; ?><br>
      <strong>Last Send Date:</strong> <?php echo $rec['lastsenddate']; ?> </td>
    <td valign="top" bgcolor="#FFFFFF"><strong>SMS Type:</strong> <?php echo $rec['smstype']; ?>&nbsp;
		<?php if($rec['recurringtype']) { ?>
		<br>
      <strong>Recurring Type:</strong> <?php echo $rec['recurringtype']; ?>
	  <?php } ?>
	  <?php if($rec['recurringfixedtypedates']) { ?>
	  <br>
      <strong>Recurring Dates: </strong><?php echo $rec['recurringfixedtypedates']; ?>
	  <?php } ?> </td>
    <td valign="top" bgcolor="#FFFFFF"><?php if($rec['status']==1) { ?>
      <a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/sms/index.php','GET','statusId=<?php echo $rec['id']; ?>&status=0', '', 'center', 'yes', '', '0');">Make Inactive</a>
      <?php } else { ?>
      <a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/sms/index.php','GET','statusId=<?php echo $rec['id']; ?>&status=1', '', 'center', 'yes', '', '0');">Make Active</a>
      <?php } ?>
      <a href="#" onClick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/sms/index.php','GET','delId=<?php echo $rec['id']; ?>', '', 'center', 'yes', '', '0');">Delete</a>    </td>
  </tr>
	<?php } ?>
</table>
	<?php if($totalPages>0) echo "<p>".$paginate."</p>"; ?>
<?php } ?>
<?php $SMS->cronSMS(); ?>
