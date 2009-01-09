<?php 
include_once("inc_dbcon.php"); 

$confirmPassword = $_GET["cp"];
$action          = $_GET["a"];
$k="";
	if (isset($_GET["k"]))
		$k = "&k=" . $_GET["k"];

$sql = "SELECT * FROM md_postings WHERE confirmPassword='$confirmPassword'";
if ($result = mysql_query($sql)){
//
} else {
        	print("Hmmm... something went wrong activating your post:<br>" . mysql_error());
}

$num_rows = mysql_num_rows($result);
$row = mysql_fetch_array($result);

if ($num_rows > 0){
   if ($action == "confirm")
   {
	   mysql_query("UPDATE md_postings SET isConfirmed='1' WHERE confirmPassword='$confirmPassword'");
	   header("Location: viewItem.php?id=" . $row["postId"] . "&msg=activated");
   }
   if ($action == "delete")
   {
       mysql_query("DELETE from md_postings WHERE confirmPassword='$confirmPassword'");	
		header("Location: index.php?&msg=deleted". $k);
   }
   if ($action == "deact")
   {
	   mysql_query("UPDATE md_postings SET isAvailable='0' WHERE confirmPassword='$confirmPassword'");
		header("Location: viewItem.php?id=" . $row["postId"] . "&msg=deactivated". $k);
   }
  if ($action == "react")
   {
	   mysql_query("UPDATE md_postings SET isAvailable='1' WHERE confirmPassword='$confirmPassword'");
	   header("Location: viewItem.php?id=" . $row["postId"] . "&msg=reactivated&admin=true". $k);
   }
} else {
     print("The item specified could not be found. Please try again.");
}
?>