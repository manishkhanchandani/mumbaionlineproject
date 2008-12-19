<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
include('Classes/PaginateIt.php');
if($_GET['page']) $_GET['pageNum_rsView'] = $_GET['page']-1;
if(!$_GET['from']) $_GET['from'] = '0001-01-01';
if(!$_GET['to']) $_GET['to'] = '3000-01-01';

$maxRows_rsView = 10;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;

$colname_rsView = "5";
if (isset($_COOKIE['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
$coldate1_rsView = "1971-01-01";
if (isset($_GET['from'])) {
  $coldate1_rsView = (get_magic_quotes_gpc()) ? $_GET['from'] : addslashes($_GET['from']);
}
$coldate2_rsView = "2008-12-15";
if (isset($_GET['to'])) {
  $coldate2_rsView = (get_magic_quotes_gpc()) ? $_GET['to'] : addslashes($_GET['to']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT history.*, user.email FROM history LEFT JOIN user ON history.user_id = user.user_id WHERE history.user_id = %s AND history.history_date BETWEEN '%s' AND '%s' ORDER BY history.history_date DESC", $colname_rsView,$coldate1_rsView,$coldate2_rsView);
$query_limit_rsView = sprintf("%s LIMIT %d, %d", $query_rsView, $startRow_rsView, $maxRows_rsView);
$rsView = mysql_query($query_limit_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);

if (isset($_GET['totalRows_rsView'])) {
  $totalRows_rsView = $_GET['totalRows_rsView'];
} else {
  $all_rsView = mysql_query($query_rsView);
  $totalRows_rsView = mysql_num_rows($all_rsView);
}
$totalPages_rsView = ceil($totalRows_rsView/$maxRows_rsView)-1;
?>
<?php
$PaginateIt = new PaginateIt();
$PaginateIt->SetCurrentPage(($pageNum_rsView+1));
$PaginateIt->SetItemsPerPage($maxRows_rsView);
$PaginateIt->SetItemCount($totalRows_rsView);
$paginate = $PaginateIt->GetPageLinks();
?>
<h1>View My History</h1>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <th width="10%">Date</th>
      <th width="25%">Title</th>
      <th width="40%">Detail</th>
      <th width="25%">Public</th>
      <th width="25%">Edit</th>
      <th width="25%">Delete</th>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_rsView['history_date']; ?></td>
        <td><?php echo $row_rsView['history_title']; ?></td>
        <td><?php echo $row_rsView['history_detail']; ?></td>
        <td><?php echo $row_rsView['public']; ?></td>
        <td><a href="#">Edit</a></td>
        <td><a href="#">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
  </table>
	  <?php if($totalPages_rsView>0) { ?>
	  <p><?php echo $paginate; ?></p>
	  <?php } ?>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
  <p>No History Found.  </p>
  <?php } // Show if recordset empty ?><?php
mysql_free_result($rsView);
?>