<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
if(!$_COOKIE['user_id']) {
	echo '<p class="error">You are not logged on to the site</p>';
	exit;
}
$initialUrl = urlencode($_SERVER['PHP_SELF']);
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

$colname_rsPhoneBook = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsPhoneBook = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsPhoneBook = sprintf("SELECT * FROM phonebook WHERE user_id = %s ORDER BY name ASC", $colname_rsPhoneBook);
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
<h1>My Phone Contacts</h1>
<p><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/new.php','GET','initialUrl=<?php echo HTTPROOT; ?>/modules/phonebook/view.php', '', 'center', 'yes', '<?php echo md5("modules/phonebook/new.php"); ?>', '1');">Add New Contact</a></p>
<?php if ($totalRows_rsPhoneBook > 0) { // Show if recordset not empty ?>
  <table border="0" cellpadding="5" cellspacing="1" class="table">
    <tr class="th">
      <td valign="top">Name</td>
      <td valign="top">Phone</td>
      <td valign="top">Email</td>
      <td valign="top">Comments</td>
      <td valign="top">Public</td>
      <td valign="top">Created</td>
      <td valign="top">Edit</td>
      <td valign="top">Delete</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td valign="top"><?php echo $row_rsPhoneBook['name']; ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['phone']; ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['email']; ?></td>
        <td valign="top"><?php echo nl2br($row_rsPhoneBook['comments']); ?></td>
        <td valign="top"><?php echo ($row_rsPhoneBook['public']==1)?'Public':'Private'; ?></td>
        <td valign="top"><?php echo $row_rsPhoneBook['created']; ?></td>
        <td valign="top"><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/edit.php','GET','phonebook_id=<?php echo $row_rsPhoneBook['phonebook_id']; ?>&initialUrl=<?php echo $initialUrl; ?>', '', 'center', 'yes', '<?php echo md5("modules/phonebook/edit.php"); ?>', '1');">Edit</a></td>
        <td valign="top"><a href="<?php echo HTTPROOT; ?>/modules/phonebook/delete.php?phonebook_id=<?php echo $row_rsPhoneBook['phonebook_id']; ?>&initialUrl=<?php echo $initialUrl; ?>" onClick="return confirmDelete('Are you sure you want to delete this record?');">Delete</a></td>
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
