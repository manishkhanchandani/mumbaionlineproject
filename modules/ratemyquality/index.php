<?php require_once('Connections/conn.php'); ?>
<?php
include_once('start.php');
?>
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
$query_rsQualities = sprintf("SELECT rate_my_qualities_question.quality, rate_my_qualities_question.qid, rate_my_qualities_question.avg_rating, rate_my_qualities_question.total_votes, rate_my_qualities_question.total_rating FROM rate_my_qualities_relation, rate_my_qualities_question, rate_my_qualities WHERE rate_my_qualities_relation.qid = rate_my_qualities_question.qid AND rate_my_qualities_relation.id = rate_my_qualities.id AND rate_my_qualities.id = %s", $colid_rsQualities);
$rsQualities = mysql_query($query_rsQualities, $conn) or die(mysql_error());
$row_rsQualities = mysql_fetch_assoc($rsQualities);
$totalRows_rsQualities = mysql_num_rows($rsQualities);
?>
<?php
if($_POST['MM_Insert']==1) {	
	if(!$_COOKIE['user_id']) {
		$initialUrl = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
		setcookie('goto',$initialUrl,0,'/');
		header("Location: ".HTTPROOT."/index.php?initialUrl=".HTTPROOT."/modules/users/login.php");
		exit;
	}
	if($_COOKIE['user_id']==$row_rsView['user_id']) {
		$msg = '<p class="error">You cannot vote yourself.</p>';
	} else {
		
		foreach($_POST as $k => $v) {
			if(!eregi('star_', $k)) continue;
			$qid = str_replace('star_','',$k);
			if($v) {
				$sql = "insert into rate_my_qualities_vote(id, user_id, qid, vote) values ";
				$sql .= "('".$_GET['id']."', '".$_COOKIE['user_id']."', '".$qid."', '".$v."')";
				@mysql_query($sql);
		
				$sql2 = "update rate_my_qualities_question set `total_votes` = `total_votes`+1, `total_rating` = `total_rating`+".$v.", avg_rating = `total_rating`/`total_votes` where qid = '".$qid."'";
				@mysql_query($sql2);
				
			}
		}
		$msg = '<p class="error">You have successfully voted the selected qualities.</p>';
	}
}
if($_COOKIE['user_id']==$row_rsView['user_id']) {
	$disable = 'disabled="disabled"';
	$self = 1;
} else if(!$_COOKIE['user_id']) {
	$disable = 'disabled="disabled"';
}
?>
<?php
$colid_rsVoted = "-1";
if (isset($_GET['id'])) {
  $colid_rsVoted = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
$colname_rsVoted = "-1";
if (isset($_COOKIE['user_id'])) {
  $colname_rsVoted = (get_magic_quotes_gpc()) ? $_COOKIE['user_id'] : addslashes($_COOKIE['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsVoted = sprintf("SELECT * FROM rate_my_qualities_vote WHERE user_id = %s AND id = %s", $colname_rsVoted,$colid_rsVoted);
$rsVoted = mysql_query($query_rsVoted, $conn) or die(mysql_error());
$row_rsVoted = mysql_fetch_assoc($rsVoted);
$totalRows_rsVoted = mysql_num_rows($rsVoted);
?>
<?php
if($totalRows_rsVoted>0) {
	do {
		$alreadyvoted[$row_rsVoted['qid']] = $row_rsVoted['vote'];
	} while($row_rsVoted = mysql_fetch_assoc($rsVoted)); 
}
$chk = 'checked="checked"';
$disabled = 'disabled="disabled"';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Rate My Qualities :: <?php echo $row_rsView['name']; ?></title>
<!-- InstanceEndEditable -->
<script type="text/javascript">
var HTTPROOT = "<?php echo HTTPROOT; ?>";
</script>
<link href="<?php echo HTTPROOT; ?>/assets/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo HTTPROOT; ?>/libs/jquery/jquery-1.2.6.js"></script>
<!-- Menu System -->
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/jquery/treeview/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/jquery/treeview/screen.css" />

<script src="<?php echo HTTPROOT; ?>/libs/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo HTTPROOT; ?>/libs/jquery/treeview/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">	
	$(function() {
		$("#tree").treeview({
			collapsed: true,
			animated: "medium",
			control:"#sidetreecontrol",
			persist: "location"
		});
	})	
</script>
<!-- Menu System -->

<!-- datepicker -->
<link rel="stylesheet" href="<?php echo HTTPROOT; ?>/libs/core.ui.datepicker/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="<?php echo HTTPROOT; ?>/libs/core.ui.datepicker/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<!-- datepicker ends -->
<script src="<?php echo HTTPROOT; ?>/libs/jquery/jquery.cache2.js" type="text/javascript"></script>
<script language="javascript" src="<?php echo HTTPROOT; ?>/assets/js/script.js"></script>
<?php if($globalPluginJs) { ?>
	<?php foreach($globalPluginJs as $jsFile) { ?>
		<script language="javascript" src="<?php echo $jsFile; ?>"></script>
	<?php } ?>
<?php } ?>
<?php if($globalPluginCss) { ?>
	<?php foreach($globalPluginCss as $cssFile) { ?>
		<link href="<?php echo $cssFile; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
<?php } ?>
<?php if($_GET['initialUrl']) { ?>
<script language="javascript">
	window.onload = function() {
		doAjaxLoadingText('<?php echo urldecode($_GET['initialUrl']); ?>','GET','<?php echo $_SERVER['QUERY_STRING']; ?>','','center','yes','',0);
	}
</script>
<?php } ?>
<!-- InstanceBeginEditable name="head" -->
<script src="<?php echo HTTPROOT; ?>/libs/jquery/rating/jquery.rating.js" type="text/javascript" language="javascript"></script>
<link href="<?php echo HTTPROOT; ?>/libs/jquery/rating/jquery.rating.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#image img {
		border:solid 1px black;
		max-width: 320px;
		width: expression(this.width > 320 ? 320: true);
	}
	.ratingcontent {
		width: 100%;
		float:left;
	}
	.clear {
		clear:both;
	}
	.ratingul {
	list-style-type: none;	
	}
	.ratingli {
	
	}
</style>
<script type="text/javascript" language="javascript">
$(function(){ 
 $('.formrating :radio.star').rating(); 
});
</script>
<!-- InstanceEndEditable -->
</head>
<?php flush(); ?>

<body>
<div id="mainContent">
	<div id="head"></div>
	<div id="header"><a href="<?php echo HTTPROOT; ?>"><img src="<?php echo HTTPROOT; ?>/assets/images/mumbaionline_org_in.jpg" border="0" /></a></div>
	<div style="clear:both"></div>
	<div id="middle">
		<div id="left">
		<?php include(DOCROOT.'/assets/xtras/menu.php'); ?>
		</div>
		<div id="center">	
<!-- InstanceBeginEditable name="EditRegion3" -->
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h1><?php echo $row_rsView['name']; ?></h1>
  <?php echo $msg; ?>
  <table border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td valign="top"><div id="image"><?php if($row_rsView['photo']) { ?><img src="<?php echo HTTPROOT."/modules/ratemyquality/images/".$row_rsView['id']; ?>_<?php echo $row_rsView['photo']; ?>" /><?php } else { ?><img src="<?php echo HTTPROOT."/assets/images/noImageAvailable.jpg"; ?>" /><?php } ?></div>
	  </td>
      <td valign="top"><h3>Rate My Following Qualities </h3>
        <?php if ($totalRows_rsQualities > 0) { // Show if recordset not empty ?>
			<form id="formRating" method="post" name="formRating" action="" class="formrating">
            <table>
              <?php do { ?>
				<?php 
					$put = '';
					$val = '';
					if($disable) {
						$put .= $disable; 
						$val = -1;
					} else {
						if($alreadyvoted[$row_rsQualities['qid']]) {
							$put .= $disabled; 
							$val = -1;
						}
						if($alreadyvoted[$row_rsQualities['qid']]==1) {
							$put .= $chk; 
							$val = -1;
						}
					}
					if($self==1) {
						$avg_rating_profile[$row_rsQualities['qid']] = round($row_rsQualities['avg_rating']);
					}
				?>
                <tr><td><div class="ratingcontent"><strong><?php echo $row_rsQualities['quality']; ?></strong><br />
						<?php for($i=1; $i<=10; $i++) { ?>
							<input name="star_<?php echo $row_rsQualities['qid']; ?>" type="radio" class="star" value="<?php if($val!=-1) echo $i; else echo ''; ?>" <?php if($disable) echo $disable; if($alreadyvoted[$row_rsQualities['qid']]) echo $disabled; if($avg_rating_profile[$row_rsQualities['qid']]==$i) echo $chk; if($alreadyvoted[$row_rsQualities['qid']]==$i) echo $chk; ?> />
						<?php } ?>
					</div>
				</td></tr>
              <?php } while ($row_rsQualities = mysql_fetch_assoc($rsQualities)); ?>
            </table>
			<blockquote>
				<?php if($self!=1) { ?>
				<div><br /><input type="submit" value="<?php if($_COOKIE['user_id']) { ?>Submit scores!<?php } else { ?>Login To Vote<?php } ?>" />
							<input type="hidden" name="MM_Insert" value="1" />
				</div>
				<?php } ?>	
				<p>&nbsp;</p>		
				<?php if($_COOKIE['user_id']) include(DOCROOT."/modules/ratemyquality/menu.php"); ?>
			</blockquote>
			<div class="test">
    			
   			</div>
			</form>
          <?php } // Show if recordset not empty ?>
		  <?php if ($totalRows_rsQualities == 0) { // Show if recordset is empty ?>
		  <p class="error">Rating on this profile is not yet started as qualites are not yet being defined by the owner.</p>
          <?php } // Show if recordset is empty ?>
		  </td>
    </tr>
      </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
  <h1>Error</h1>
  <p>No Page Found. </p>
  <?php } // Show if recordset empty ?><p>&nbsp;</p>
<!-- InstanceEndEditable -->
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="footer" align="center">
	  <p>Copyright &copy; 2008-2009 <a href="<?php echo $base; ?>">Mumbaionline.org.in</a> </p>
	  <p>This site is made using php, mysql, adodb, pear, jquery functionalities<br />
      This site is designed and developed by only one technical lead developer: <a href="mailto:mkgxy@mkgalaxy.com">Manish Khanchandani</a></p>
<?php include_once(DOCROOT.'/end.php'); ?>

	</div>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsView);

mysql_free_result($rsQualities);

mysql_free_result($rsVoted);
?>
