<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
include('Classes/PaginateIt.php');
if($_GET['page']) $_GET['pageNum_rsView'] = $_GET['page']-1;

$maxRows_rsView = 10;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;

mysql_select_db($database_conn, $conn);
$query_rsView = "SELECT history.*, user.email FROM history LEFT JOIN user ON history.user_id = user.user_id WHERE history.public = 'Y' ORDER BY history.history_date DESC";
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
<h1>View Complete History</h1>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <th width="10%">Date</th>
      <th width="25%">Title</th>
      <th width="40%">Detail</th>
      <th width="25%">User's Email </th>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_rsView['history_date']; ?></td>
        <td><?php echo $row_rsView['history_title']; ?></td>
        <td><?php echo $row_rsView['history_detail']; ?></td>
        <td><?php echo $row_rsView['email']; ?></td>
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