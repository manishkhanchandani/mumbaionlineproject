<?php
 include_once("inc_header.php");
 include_once("../inc_dbcon.php");
 
$op = $_REQUEST["op"];

if ($op == "newCategory"){	
	$cat_name = $_GET["cat_name"];
	$cat_order = $_GET["cat_order"];
	$sql = "insert INTO md_categories SET cat_name='$cat_name', cat_order='$cat_order'";
		if (mysql_query($sql))
			{
				header("Location:categories.php?msg=Added");
			} else {
				print("Hmmm... something went wrong creating a categorys:<br><b>" . mysql_error());
			}
}
if ($op == "editCategory"){
	$cat_name = $_GET["cat_name"];
	$cat_order = $_GET["cat_order"];
	$cat_id = $_GET["cat_id"];

$sql = "UPDATE md_categories SET cat_name='$cat_name', cat_order='$cat_order' WHERE cat_id ='$cat_id'";

		if (mysql_query($sql))
			{
				header("Location:categories.php?msg=Updated");
			} else {
				print("Hmmm... something went wrong updating a category:<br><b>" . mysql_error());
			}
}

if ($op == "delete"){	
	$cat_id = $_GET["cat_id"];
	$sql = "DELETE FROM md_categories WHERE cat_id='$cat_id'";
		if (mysql_query($sql))
			{
				header("Location:categories.php?msg=Deleted");
			} else {
				print("Hmmm... something went wrong deleting a category:<br><b>" . mysql_error());
			}
}

?>