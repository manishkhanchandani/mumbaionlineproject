<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
include('Classes/PaginateIt.php');
if($_GET['page']) $_GET['pageNum_rsPhoneBook'] = $_GET['page']-1;
?>
<?php
$maxRows_rsPhoneBook = 10;
$pageNum_rsPhoneBook = 0;
if (isset($_GET['pageNum_rsPhoneBook'])) {
  $pageNum_rsPhoneBook = $_GET['pageNum_rsPhoneBook'];
}
$startRow_rsPhoneBook = $pageNum_rsPhoneBook * $maxRows_rsPhoneBook;

mysql_select_db($database_conn, $conn);
$query_rsPhoneBook = "SELECT * FROM phonebook WHERE `public` = 1 ORDER BY name ASC";
$query_limit_rsPhoneBook = sprintf("%s LIMIT %d, %d", $query_rsPhoneBook, $startRow_rsPhoneBook, $maxRows_rsPhoneBook);
$rsPhoneBook = mysql_query($query_limit_rsPhoneBook, $conn) or die(mysql_error());
$row_rsPhoneBook = mysql_fetch_assoc($rsPhoneBook);

if (isset($_GET['totalRows_rsPhoneBook'])) {
  $totalRows_rsPhoneBook = $_GET['totalRows_rsPhoneBook'];
} else {
  $all_rsPhoneBook = mysql_query($query_rsPhoneBook);
  $totalRows_rsPhoneBook = mysql_num_rows($all_rsPhoneBook);
}
$totalPages_rsPhoneBook = ceil($totalRows_rsPhoneBook/$maxRows_rsPhoneBook)-1;
?>
<?php
$PaginateIt = new PaginateIt();
$PaginateIt->SetCurrentPage(($pageNum_rsPhoneBook+1));
$PaginateIt->SetItemsPerPage($maxRows_rsPhoneBook);
$PaginateIt->SetItemCount($totalRows_rsPhoneBook);
$paginate = $PaginateIt->GetPageLinks();
?>
<h1>Phone Contacts</h1>
<?php if ($totalRows_rsPhoneBook > 0) { // Show if recordset not empty ?>
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <td valign="top">Name</td>
      <td valign="top">Phone</td>
      <td valign="top">Email</td>
      <td valign="top">Comments</td>
      <td valign="top">Created</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td valign="top"><?php echo $row_rsPhoneBook['name']; ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['phone']; ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['email']; ?></td>
        <td valign="top"><?php echo nl2br($row_rsPhoneBook['comments']); ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['created']; ?></td>
      </tr>
      <?php } while ($row_rsPhoneBook = mysql_fetch_assoc($rsPhoneBook)); ?>
  </table>
  <p><?php echo $paginate; ?></p>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsPhoneBook == 0) { // Show if recordset empty ?>
  <p>No Contact Found. </p>
  <?php } // Show if recordset empty ?><p>&nbsp;</p>
<?php
mysql_free_result($rsPhoneBook);
?>
