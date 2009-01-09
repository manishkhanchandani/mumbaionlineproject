<?php 
	include_once("inc_dbcon.php"); 
	include_once('admin/config.php');
    include_once($languageFile);
// check to see if in admin mode and validate key

global $keyOut;
$keyOut = "";
$adminMode = false;
if (isset($_GET["k"]))
	if($_GET["k"] == $key) { // Key comes from admin/password.php file
		$adminMode = true;
		$keyOut = "&k=" . $key;
}
	if (!isset($_GET["id"])) {
		print("This posting was not found. Please go back and try again.");
		exit();
	} 
	$postId = mysql_real_escape_string($_GET["id"]);
	$result = mysql_query("SELECT *,DATE_FORMAT(timeStamp,'%b %d, %Y %l:%i %p') AS timeStamp FROM md_postings WHERE postId='$postId'");
	if (!$result){    
		print("Houston we have a problem: " . mysql_error());    
		exit();  
	}
		while ($row = mysql_fetch_array($result)){
			$title 		 	 = trim($row["title"]);
			$description 	 = trim($row["description"]);
			$price 		 	 = trim($row["price"]);
			$type			 = trim($row["type"]);
			$name			 = trim($row["name"]);
			$city			 = trim($row["city"]);
			$imgURL 		 = $row["imgURL"];
			$ipAddress 		 = $row["ip"];
			$email 			 = trim($row["email"]);
			$cp 			 = $row["confirmPassword"]; 
			$currentCat		 = $row["category"]; // This is the current category used in navigation.
			
			if ($price == 0) 
				$price = "Free";
			else
				$price = "$" . $price;
				
			$timeStamp 	 = $row["timeStamp"];
			$isAvailable = $row["isAvailable"];
		}
		$msg = "";
		if (isset($_GET["msg"]))
			$msg = mysql_real_escape_string($_GET["msg"]);

		if ($isAvailable == 0 )
			$msg = STR_NOLONGERAVAILABLE;
		
		if ($name == "") 
			$name = "<span class='md_help'>" . STR_UNDISCLOSED . "</span>\n";
		
		$photo = "";	
		if ($imgURL != "no file")
			$photo = "<img src='$imgURL' hspace=12 vspace=12 class='md_photo'>";
			
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>View Item</title>
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


<script language="JavaScript" type="text/JavaScript">
function show(lyr){
	d = document.getElementById(lyr).style.display
	if (d == "none")
		document.getElementById(lyr).style.display = ""
	else
		document.getElementById(lyr).style.display = "none"
}
function md_validateForm(){
	d = document.form1
	e = false // no erros by default
	if(d.md_message.value == ''){
		d.md_message.className = 'md_errorField';
		d.md_message.focus();
		document.getElementById('md_messageLabel').className = 'md_errorText';
		e=true;
	}
	if ((d.email2.value.indexOf(".") > 2) && (d.email2.value.indexOf("@") > 0)){
		// it looks like an email address
	} else {
		d.md_email2.className = 'md_errorField';
		d.md_email2.focus();
		document.getElementById('md_email2Label').className = 'md_errorText';
		e=true;
	}
	if(!e) 
	  document.form1.submit()			
}
</script>
<link href="md_style.css" rel="stylesheet" type="text/css" />
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
<div id="md_container">	
  <div id="md_content">
    <?php if ($msg != "") {  // If there is a message, display it
			if ($msg == "deactivated")
				$msg = STR_MESSAGEDEACTIVATED;
			if ($msg == "activated")
				$msg = STR_MESSAGEACTIVATED;
			if ($msg == "messageSent")
				$msg = STR_MESSAGESENT;
			print("<br clear='all'><div class='md_msg'>$msg</div>"); 
		}
	 ?>
    <div class="md_itemTitle"> 
	  <?php echo $title; ?> &#8212; 
      <?php echo $price; ?></div>

	<?php	if ($adminMode){ ?>	
	<script language="JavaScript">
		function adminAction(val){
			window.location.href = "action.php?a=" + val + "&cp=<?php echo $cp; ?>&k=<?php echo $_GET['k']; ?>"
		}
	</script>
		<div class="md_admin" style="display:inline; float:right;">
			<a href="javascript:adminAction('delete');" title="This will delete the item, but not any photos, you'll have to clean that up on the server"><?php echo STR_DELETEPOST; ?></a> 
		  | <a href="javascript:adminAction('deact');" title='Will not delete, but show others that things are getting taken... and activity'><?php echo STR_MARKASTAKEN; ?></a> 
		</div>
	<?php }	?> 
	
    <div id='md_fromDate' class="md_itemTitleSub">
		<span class='md_labelViewItem'><?php echo STR_TYPEOFADD; ?></span>	<?php echo $type; ?> <span class='md_divider'>&nbsp;|&nbsp;</span>
		<span class='md_labelViewItem'><?php echo STR_FROM; ?></span>	<?php echo $name; ?> <span class='md_divider'>&nbsp;|&nbsp;</span>
		<span class='md_labelViewItem'><?php echo STR_CITY; ?></span>	<?php echo $city; ?> <span class='md_divider'>&nbsp;|&nbsp;</span>
		<span class='md_labelViewItem'><?php echo STR_POSTED; ?></span> <?php echo $timeStamp; ?>
		
		<?php	if ($adminMode){ ?>
		<span class='md_divider'>&nbsp;|&nbsp;</span>
		<span class='md_labelViewItem' style="color:maroon"><?php echo STR_IPADDRESS . " " . $ipAddress; ?></span> 
		<span class='md_divider'>&nbsp;|&nbsp;</span>
		<span class='md_labelViewItem' style="color:maroon"><?php echo STR_EMAIL; ?> <?php echo $email; ?></span> 
		<?php } ?>
	</div>
	
    <div id="md_viewItemContent"> 
		<?php print (nl2br($description)); ?><br clear="all">
		<?php echo $photo; ?>
	</div>
	
	<div id='md_myPostLink'>
		<a href='javascript:show("myPost")'><?php echo STR_THISISMYPOSTING; ?></a>  
	</div>
	<div id='myPost' style='position:absolute; display:none; padding:12px; width:400px; border:4px solid #6C9CFF; background-image:url(images/bg_form.gif)'>
		<?php echo STR_THISISMYPOSTINGTEXT; ?> <br /><br />
		<form name='form2' action='controller.php' method="post">
			<input type='Submit' value='<?php echo STR_SENDEMAILREMINDER; ?>' class='md_bigButton'>
			<input type='hidden' name='postId' value='<?php echo $postId; ?>'> &nbsp;
			<input type='hidden' name='op' value='emailReminder'> &nbsp;
			<a href='javascript:show("myPost")'><?php echo STR_CANCEL; ?></a> 
		</form>
	</div>

<?php 
// Only show emailing form if the item is available 
if ($isAvailable == 1) { ?>
	<br><br>
    <div id="md_emailBox">
      <form action="controller.php" method="post" name="form1" id="form1" class='md_form' style="display:inline">
        <div class="md_formTitle"><?php echo STR_EMAILTHISPERSON; ?></div>
        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td><?php echo STR_YOURNAME; ?><br />
              <input name="name" type="text" id="name" size="20" />
			</td>
            <td>&nbsp;</td>
            <td><span id="md_email2Label"><?php echo STR_YOURMAIL; ?></span><br />
			   <input name="Email" type="text" id="md_email" size="40" maxlength="90" />
               <input name="email2" type="text" id="md_email2" size="40" />
			</td>
          </tr>
        </table>
        <div>&nbsp;<br />
        <span id="md_messageLabel"><?php echo STR_YOURMESSAGE; ?></span></div>
        <textarea name="md_message" cols="60" rows="6" id="md_message" style="width:96%"></textarea>
        <input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>" />
        <input type="hidden" name="title" value="<?php echo $title; ?>" />
        <input name="op" type="hidden" value="email" />
        <div class="md_submit"> &nbsp;<br />
          <input name="Submit" type="button" class="md_bigButton" onclick="md_validateForm()" value="<?php echo STR_SENDEMAIL; ?>" />
        </div>
      </form>
    </div>
    <?php } ?>
  </div>
</div>
<?php include_once("inc_footer.php");?>
<!-- InstanceEndEditable -->
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="footer" align="center">
		<?php include_once(DOCROOT.'/end.php'); ?>
	</div>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</body>
<!-- InstanceEnd --></html>
<?php 
	mysql_free_result($result); 
	mysql_close($dbConn);
?>