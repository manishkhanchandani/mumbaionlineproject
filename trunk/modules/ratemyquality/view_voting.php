<?php require_once('Connections/conn.php'); ?>
<?php 
include_once('start.php'); 
include('Classes/PaginateIt.php');
if($_GET['page']) $_GET['pageNum_rsView'] = $_GET['page']-1;
?>
<?php
$colname_rsProfile = "-1";
if (isset($_GET['id'])) {
  $colname_rsProfile = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsProfile = sprintf("SELECT * FROM rate_my_qualities WHERE id = %s", $colname_rsProfile);
$rsProfile = mysql_query($query_rsProfile, $conn) or die(mysql_error());
$row_rsProfile = mysql_fetch_assoc($rsProfile);
$totalRows_rsProfile = mysql_num_rows($rsProfile);

$maxRows_rsView = 25;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;

$colname_rsView = "-1";
if (isset($_GET['id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT `user`.email, rate_my_qualities_vote.vote, rate_my_qualities_question.quality FROM rate_my_qualities_vote LEFT JOIN user ON rate_my_qualities_vote.user_id = user.user_id LEFT JOIN rate_my_qualities_question ON rate_my_qualities_vote.qid = rate_my_qualities_question.qid WHERE rate_my_qualities_vote.id = %s ORDER BY `user`.email, rate_my_qualities_question.quality", $colname_rsView);
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
<h1>View Voting for Profile &quot;<?php echo $row_rsProfile['name']; ?>&quot;</h1>
<?php include(DOCROOT."/modules/ratemyquality/menu.php"); ?>

<?php if($totalRows_rsView>0) { ?>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tr class="th">
    <td>Email</td>
    <td>Quality</td>
    <td>Vote</td>
  </tr>
  <?php do { ?>
    <tr class="td">
      <td><?php if($tmpEmail==$row_rsView['email']) echo '&nbsp;'; else echo $tmpEmail = $row_rsView['email']; ?></td>
      <td><?php echo $row_rsView['quality']; ?></td>
      <td><?php echo $row_rsView['vote']; ?></td>
    </tr>
    <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
</table>
	<?php if($totalPages_rsView) { ?>
	<p><?php echo $paginate; ?></p>
	<?php } ?>
<?php } else { ?>
<p>No Voting Result Found.</p>
<?php } ?>
<?php
mysql_free_result($rsProfile);

mysql_free_result($rsView);
?>
