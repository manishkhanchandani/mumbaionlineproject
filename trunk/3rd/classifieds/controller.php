<?php
 include_once("inc_dbcon.php");  
 include_once('inc_thumbnail.php'); 
 include_once('inc_functions.php'); 
 include_once('admin/config.php');
 include_once($languageFile);

$ip = GetHostByName($REMOTE_ADDR);
$op = $_REQUEST["op"]; // op is the operation code
$msg = "";

if ($op == "newItem"){

	$botEmail = $_POST["email"]; 
	// this should not be filled in if it is a human filling out the form because the email field should be hidden via css
	// if it is filled in, send them over to the fbi's site  :)
	if ($botEmail != '')
		header("Location:http://www.fbi.gov?ip=" . GetHostByName($REMOTE_ADDR));
				
	// begin hacker defense - Thanks Kreuznacher | wurdzwurk
	foreach ($_POST as $secvalue) {
		if ((eregi("<[^>]*script.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*object.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*iframe.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*applet.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*window.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*document.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*cookie.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*meta.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*style.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*alert.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*form.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*php.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*<?.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*img.*\"?[^>]*>", $secvalue))) {
			die ("There was a problem with your post");
		}
	}
	// end hacker defense 	
	
	$title 			= mysql_real_escape_string(addslashes(trim($_POST["md_title"])));
	$description	= mysql_real_escape_string(addslashes(trim($_POST["md_description"])));
	$price 			= mysql_real_escape_string(addslashes(trim($_POST["md_price"])));
	$email 			= mysql_real_escape_string(trim($_POST["md_email2"]));
	$city 			= mysql_real_escape_string(addslashes(trim($_POST["city"])));
	$namer 			= mysql_real_escape_string($_POST["namer"]);
	$category		= mysql_real_escape_string($_POST["category"]);
	$type			= mysql_real_escape_string($_POST["type"]);
	
	// upload the file if it exists
	$file	= uploadImage($_POST["uploadform"]);
	// Create a Thumbnail if an image exists
	if ($file != "no file")
	{	
		$date = date("YmdHis");
		$imgArr = split('[/]', $file);
		$imgNameOnly = $imgArr[sizeof($imgArr)-1];
		$folderPath = "";
		for ($i=0; $i<sizeof($imgArr)-1; $i++)
			$folderPath .=  $imgArr[$i] . "/" ;	
			
		$photoPathName = $folderPath . $date . "_" . $imgNameOnly;
		$thumbNailPathName = $folderPath . "thumb_" . $date . "_" . $imgNameOnly;
		$imgType = getImgType($imgNameOnly);
		// Create a resized image of the orig. a mx of 400 pixels
		$photo=new Thumbnail(400,400);
		// Load an image into a string (this could be from a database)
		$image=file_get_contents($file);
		// Load the image data
		$photo->loadData($image,$imgType);
		// Build the thumbnail and store as a file
		$photo->buildThumb($photoPathName);	
		// Instantiate the thumbnail
		$tn=new Thumbnail(50,50);
		// Load an image into a string (this could be from a database)
		$image=file_get_contents($file);
		// Load the image data
		$tn->loadData($image,$imgType);
		// Build the thumbnail and store as a file
		$tn->buildThumb($thumbNailPathName);
		// delete the source file that is potentially large
		unlink($file);
	}

	// Creates a 7 character random string
	$confirmPassword = chr(rand (97,122)) . chr(rand (97,122)) . chr(rand (97,122)) . chr(rand (97,122)) . chr(rand (97,122)) . chr(rand (97,122)) . chr(rand (97,122));	

	$sql = "insert INTO md_postings SET email='$email', type='$type', name='$namer', city='$city', category='$category', title='$title', description='$description', price='$price', ip='$ip', confirmPassword='$confirmPassword', imgURL='$photoPathName', imgURLThumb='$thumbNailPathName'";
	
	if (mysql_query($sql)) // If all is good, send the email
		{
			include_once("admin/email_newItem.php");
			mail($email, STR_CONFIRMPOSTING, $message, $headers);
			header("Location:newItemConfirm.php");
        } else {
        	print("Hmmm... something went wrong trying to create a new item:<br>" . mysql_error());
        }	
}

if ($op == "email"){

	$botEmail = $_POST["email"];
	// this should not be filled in if it is a human filling out the form because the field should be hidden via css
	// if it is filled in, send them over to the fbi's site  :)
	if ($botEmail != '')
		header("Location:http://www.fbi.gov?ip=" . GetHostByName($REMOTE_ADDR));

	// begin hacker defense - Thanks Kreuznacher | wurdzwurk
	foreach ($_POST as $secvalue) {
		if ((eregi("<[^>]*script.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*object.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*iframe.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*applet.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*window.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*document.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*cookie.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*meta.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*style.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*alert.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*form.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*php.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*<?.*\"?[^>]*>", $secvalue)) ||
		(eregi("<[^>]*img.*\"?[^>]*>", $secvalue))) {
			die ("There was a problem with your post. Please do not include code.");
		}
	}
	// end hacker defense 	
		
	$postId 	= mysql_real_escape_string($_POST["postId"]);
	$title 		= mysql_real_escape_string(addslashes(trim($_POST["title"])));
	$name 		= mysql_real_escape_string(addslashes(trim($_POST["name"])));
	$email 		= mysql_real_escape_string(trim($_POST["email2"]));
	$message 	= "From: $name \n\n" . $_POST["md_message"];
	$emailTitle = STR_ABOUTYOURPOST . $title;
	$headers 	= 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'X-Mailer: PHP/' . phpversion();	
	
	$sql = "SELECT email FROM md_postings WHERE postId='$postId'";
	$result = mysql_query($sql);
	if (!$result)
		print("Hmmm... Error getting email address: " . mysql_error());    
		
	$row 		= mysql_fetch_array($result);
	$toEmail 	= $row["email"];
	mail($toEmail, $emailTitle, $message, $headers);
	header("Location: viewItem.php?id=$postId&msg=messageSent");
}

if ($op == "emailReminder"){
	$postId = mysql_real_escape_string($_POST["postId"]);

	$sql = "SELECT email, title, confirmPassword FROM md_postings WHERE postId='$postId'";
	$result = mysql_query($sql);
	if (!$result)
		print("Error performing query: " . mysql_error());	
	$row 		= mysql_fetch_array($result);
	$confirmPassword = $row["confirmPassword"];
	$toEmail 	= $row["email"];
	
	include_once("admin/email_reminder.php");
	mail($toEmail, STR_REMINDEREMIAL, $message, $headers);
	header("Location: viewItem.php?id=$postId&msg=messageSent");
}
?>