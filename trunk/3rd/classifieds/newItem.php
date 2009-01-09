<?php 
include_once('start.php');
if(!$_COOKIE['user_id']) {
	setcookie('goto', $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'], 0, "/");
	$url = HTTPROOT."/index.php?initialUrl=http://localhost/december2008/modules/users/login.php";
	header("Location: $url");
	exit;
}
	  include_once("inc_dbcon.php");
	  include_once("inc_functions.php");
	  include_once('admin/config.php');
	  include_once($languageFile);

global $keyOut;
$keyOut = "";
if (isset($_GET["k"]))
	if($_GET["k"] == $key){ // Key comes from admin/password.php file
		$keyOut = "&k=" . $key;
	}
	  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Add New Post</title>
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


<script language="JavaScript" type="text/javascript">
<!--
function md_validateForm(){
	d = document.form1
	e = false // no erros by default
	// Restore categories to the default so that when re-checked the UI updates
	d.md_category.className = d.md_title.className = d.md_description.className = d.md_email2.className =''
	document.getElementById('md_categoryLabel').className = document.getElementById('md_titleLabel').className = document.getElementById('md_descriptionLabel').className =document.getElementById('md_emailLabel').className = 'md_label';
	
	if(d.md_category.value == 'null'){
		d.md_category.className = 'md_errorField'
		document.getElementById('md_categoryLabel').className = 'md_errorText';
		d.md_category.focus();
		e=true;
	}
	if(d.md_title.value == ''){
		d.md_title.className = 'md_errorField'
		document.getElementById('md_titleLabel').className = 'md_errorText';
		d.md_title.focus();
		e=true;
	}
	if(d.md_description.value == ''){
		d.md_description.className = 'md_errorField';
		document.getElementById('md_descriptionLabel').className = 'md_errorText';
		d.md_description.focus();
		e=true;
	}
	if ((d.md_email2.value.indexOf(".") > 2) && (d.md_email2.value.indexOf("@") > 0)){
		// it looks like an email address
	} else {
		d.md_email2.className = 'md_errorField';
		document.getElementById('md_emailLabel').className = 'md_errorText';
		d.md_email2.focus();
		e=true;
	}
	if(!e) 
		document.form1.submit()			
}
//-->
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
<h1>Add New Classified Post</h1>
    <form action="controller.php" method="post"  enctype="multipart/form-data" name="form1" id="form1">
      <table border="0" cellpadding="8" cellspacing="0">
        <tr>
          <td align="right" valign="top"><span class="md_required">*</span> <span class="md_label" id="md_categoryLabel"><?php echo STR_CATEGORY;?></span></td>
          <td>
		   <div style="display:inline; float:right"><span class="md_required">*</span> <?php echo STR_REQUIRED;?></div>
		  <?php 
			$result2 = mysql_query("SELECT * FROM md_categories order by cat_order");
			if (!$result2){    
				print("There was a problem getting categories: <b>" . mysql_error());    
				exit();  
			}
			$counter = 0;
			// Create the HTML code for the label and select list
			$catSelectList .= "<select name='category' id='md_category'><option value='null'>- Select a category -</option>\n";
			while ($row = mysql_fetch_array($result2))
			{
				$catSelectList .= "<option value='".$row["cat_id"]."'>" . $row["cat_name"] . "</option>\n" ;
				$counter++;
			}
			$catSelectList .= "</select>";
		
			if ($counter == 0)
				echo "<input type=hidden name='category' value='0'>";		
			else
				echo $catSelectList;
		  ?></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_label"><?php echo STR_TYPE;?></span></td>
          	<td>
				<input type="radio" name="type" value="Offering" checked/> <?PHP echo STR_OFFERED; ?><br />
				<input type="radio" name="type" value="Need" /> <?PHP echo STR_NEED; ?>
		  	</td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_required">*</span> <span class="md_label" id="md_titleLabel"><?php echo STR_TITLE;?></span></td>
          <td><input name="md_title" type="text" size="50" value="" id='md_title' /></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_label"><?php echo STR_PRICE;?></span></td>
          <td>$
          <input name="md_price" type="text" size="6" value="" id='md_price' /> 
          <?php echo STR_FORFREE;?></td>
        </tr>
        <tr>
          <td align="right" valign="top" nowrap="nowrap"><span class="md_required">*</span> <span class="md_label" id="md_descriptionLabel"><?php echo STR_DESCRIPTION;?></span></td>
          <td><textarea name="md_description" cols="60" rows="6" id='md_description'></textarea></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_label"><?php echo STR_PICTURE;?></span></td>
          <td valign="top">
			<input name="filetoupload" type="file" id="filetoupload" size="40" />
            <span class="md_labelFinePrint">(4 mb max)</span>
            <input type="hidden" name="MAX_FILE_SIZE" value="409600" /></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_label"><?php echo STR_NAME;?></span></td>
          <td valign="top">
			<input name="namer" type="text" id="namer" size="40" />
          <?php echo STR_NAMEISDISPLAY;?></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_label"><?php echo STR_CITY;?></span></td>
          <td valign="top">
			<input name="city" type="text" id="md_city" size="40" maxlength="90" />
          <?php echo STR_WHERELOCATED;?></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="md_required">*</span> <span class="md_label" id="md_emailLabel"><?php echo STR_EMAIL;?></span></td>
          <td valign="top">
            <input name="Email" type="text" id="md_email" size="40" maxlength="90" />
			<input name="md_email2" type="text" id="md_email2" value="<?php echo $_COOKIE['email']; ?>" size="40" maxlength="90" readonly="readonly" />
 			<?php echo STR_MAILNOTDISPLAY;?></td>
        </tr>
        <tr>
          <td colspan="2" align="right" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td><input  name="uploadform" type="button" value="<?php echo STR_SUBMITIT ?>" id="md_submitButton" class="md_bigButton" onclick="md_validateForm()" />
          <input type="hidden" name="op" value="newItem" />
          </td>
        </tr>
      </table>
	  </form>
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