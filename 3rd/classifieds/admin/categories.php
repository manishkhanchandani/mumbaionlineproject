<?php include_once("inc_header.php");
	  include_once("../inc_dbcon.php");
 ?>
<html>
<head>
<title>Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" >
	function editCat(cid, cname, corder){
		d = document.form2
		d.cat_id.value = cid;
		d.cat_name.value = cname;
		d.cat_order.value = corder;
		document.getElementById('editCat').style.display = ''
	}	
	function cancel(){
		document.getElementById('editCat').style.display = 'none'
	}
	function deleteCategory(category, label)
		{
		if (confirm('Are you sure you want delete the category: ' + label+ '?\nAll postings in it will not be linked.\nDelete?'))
		window.location = "controller.php?op=delete&cat_id=" + category;
	}
	</script>
<link href="md_admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="title">Categories</h1>
<form name="form1" action="controller.php" method="get">
<p><a href="index.php"><img src="../images/bullet.gif" width="16" height="16" hspace="6"  border="0" align="absmiddle"></a> 
  <a href="index.php">Admin Home</a> </p>
  <p>Enter the categories for your site or update / delete existing categoires.</p>
  <table border="0" cellspacing="0" cellpadding="4" style="border:1px solid #cccccc;">
    <tr bgcolor="#ebebeb" background="../images/bg_table.gif"> 
      <td><strong>Name</strong></td>
      <td><strong>Tab Order</strong></td>
	  <td>&nbsp;</td>
    </tr>
	<tr bgcolor="#DAD8C5"> 
      <td> 
        <input type="text" name="cat_name" size="10"></td>	
      <td> 
        <input type="text" name="cat_order" size="2"></td>	
      <td> 
        <input type="submit" name="add" value="Add Category">
			<input type="hidden" name="op" value="newCategory"></td>
	</tr>
  <?php 
	$result = mysql_query("SELECT * FROM md_categories order by cat_order");
	if (!$result){    
		print("Houston we have a problem: " . mysql_error());    
		exit();  
	}
	$counter = 1;
		while ($row = mysql_fetch_array($result)){
			$cat_name = $row["cat_name"] ;
			$cat_order =  $row["cat_order"];
			$counter++;
?>
    <tr> 
      <td><?php echo $cat_name;?></td>
      <td><?php echo $cat_order;?></td>
	  <td><a href='javascript:editCat("<?php echo $row["cat_id"]; ?>", "<?php echo $cat_name;?>", "<?php echo $cat_order;?>")'>Edit</a> 
	    | <a href="javascript:deleteCategory('<?php echo $row["cat_id"] . "','" . $cat_name; ?>')"  style="color:maroon">Delete</a></td>
    </tr>
	<?php 
	$counter = $cat_order + 1;
	} ?>

  </table>
   </form>
  <script language="JavaScript">
  document.form1.cat_order.value = <?php echo $counter ; ?>
  </script>
  <div id='editCat' style="background-color:#ebebeb; width:300px; border:4px solid #6699ff; display:none; xposition:absolute;">
	<form name="form2" action="controller.php" method="get">
	<table>
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Tab Order</strong></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="text" name="cat_name" size="12"></td>
		<td><input type="text" name="cat_order" value="" size="3"></td>
		<td nowrap>
<input type="submit" value="Update">
          <a href='javascript:cancel()'>Cancel</a></td>
	</tr>
	</table>
 	<input type="hidden" name="cat_id" value=''>
	<input type="hidden" name="op" value="editCategory">
	</form>
</div>
  <p><strong>Name - </strong>The name of the category. This will appear in the 
    tabs and when a person creates a new post, they will be asked to select a 
    category.<br>
    <strong>Tab Order</strong> - This is the order you want the tabs to appear 
    in. Enter numbers 1,2,3,4,5...etc. <br>
    <strong>Edit</strong> - Change the name or the Tab Order. If you change the 
    name, all postings within that category will not be affected.<br>
    <strong>Delete</strong> - If you delete a category, all posts within that 
    category will not be deleted, but live soley in the 'All' category.</p>
  <p> If you are unsure about what categories to add, fewer is better. Let your 
    community tell you what categories you are lacking and then add it then. Less 
    is more. </p>

<p>&nbsp; </p>
</body>
</html>
