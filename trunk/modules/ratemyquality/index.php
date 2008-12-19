<?php require_once('../../Connections/conn.php'); ?>
<?php
$colname_rsView = "-1";
if (isset($_GET['id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM rate_my_qualities WHERE id = %s", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);

$colid_rsQualities = "-1";
if (isset($_GET['id'])) {
  $colid_rsQualities = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_rsQualities = sprintf("SELECT rate_my_qualities_question.quality, rate_my_qualities_question.qid FROM rate_my_qualities_relation, rate_my_qualities_question, rate_my_qualities WHERE rate_my_qualities_relation.qid = rate_my_qualities_question.qid AND rate_my_qualities_relation.id = rate_my_qualities.id AND rate_my_qualities.id = %s", $colid_rsQualities);
$rsQualities = mysql_query($query_rsQualities, $conn) or die(mysql_error());
$row_rsQualities = mysql_fetch_assoc($rsQualities);
$totalRows_rsQualities = mysql_num_rows($rsQualities);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script src="../../libs/jquery/jquery-1.2.6.js" type="text/javascript" language="javascript"></script>
<script src="../../libs/jquery/rating/jquery.rating.js" type="text/javascript" language="javascript"></script>
<link href="../../libs/jquery/rating/jquery.rating.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#image img {
		border:solid 1px black;
		max-width: 320px;
		width: expression(this.width > 320 ? 320: true);
	}
	.ratingcontent {
		width: 300px;
		float:left;
	}
</style>
<script type="text/javascript" language="javascript">
$(function(){ 
 $('.formrating :radio.star').rating(); 
});
$(function(){
 $('form').submit(function(){
  $('.test',this).html('');
  $('input',this).each(function(){ if(this.name!='') $('.test',this.form).append(''+this.name+': '+this.value+'<br/>'); });
  return false;
 });
});
</script>
</head>

<body>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h1><?php echo $row_rsView['name']; ?></h1>
  <table border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td valign="top"><div id="image"><img src="images/<?php echo $row_rsView['id']; ?>_<?php echo $row_rsView['photo']; ?>" /></div>
       </td>
      <td valign="top"><h3>Rate My Following Qualities </h3>
        <?php if ($totalRows_rsQualities > 0) { // Show if recordset not empty ?>
			<form id="formRating" method="post" name="formRating" action="" class="formrating">
            <ul>
              <?php do { ?>
                <li><strong><?php echo $row_rsQualities['quality']; ?></strong><br />
					<div class="ratingcontent">
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="1" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="2" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="3" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="4" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="5" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="6" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="7" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="8" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="9" />
						<input name="star<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="10" />						
					</div>
				</li>
              <?php } while ($row_rsQualities = mysql_fetch_assoc($rsQualities)); ?>
            </ul>
			</form>
          <?php } // Show if recordset not empty ?>	</td>
    </tr>
      </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
  <h1>Error</h1>
  <p>No Page Found. </p>
  <?php } // Show if recordset empty ?><p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsView);

mysql_free_result($rsQualities);
?>
