<?php

function drawCategories()
{

	$result2 = mysql_query("SELECT * FROM md_categories order by cat_order");
	if (!$result2){    
		print("Houston we have a problem: <b>" . mysql_error());    
		exit();  
	}
		$counter = 0;
		// Create the HTML code for the label and select list
		$catSelectList .= "<div class='md_label'>Category</div>";
		$catSelectList .= "<select name='categories'><option value='null'>- Select -</option>\n";
		while ($row = mysql_fetch_array($result))
		{
			$catSelectList .= "<option value='".$row["cat_id"]."'>" . $row["cat_name"] . "</option>\n" ;
			$counter++;
		}
		$catSelectList .= "</select>";
		
		if ($counter == 0)
			return "<input type=hidden name='category' value='0'>";		
		else
			return $catSelectList;
}

function uploadImage(){ 
	$upload_dir = "photos/";   //change to whatever you want.
             //51200 bytes = 50KB..... 1mb = 1048576
	$size_bytes = 4194304; //File Size in bytes (change this value to fit your need)

	$extlimit = "yes"; //Do you want to limit the extensions of files uploaded (yes/no)
	$limitedext = array(".jpg",".png",".jpeg",".JPG", ".PNG"); //Extensions you want files uploaded limited to.

          //check if the directory exists or not.
          if (!is_dir("$upload_dir")) {
	     	die ("The directory <b>($upload_dir)</b> doesn't exist");
          }
          //check if the directory is writable.
          if (!is_writeable("$upload_dir")){
             die ("The directory <b>($upload_dir)</b> is NOT writable, Please CHMOD (777)");
          }

              //check if no file selected.
              if (!is_uploaded_file($_FILES['filetoupload']['tmp_name']))
                     return "no file";

              //Get the Size of the File
              $size = $_FILES['filetoupload']['size'];
              //Make sure that file size is correct
              if ($size > $size_bytes)
              {
                    $kb = $size_bytes / 1024;
                    echo "The file you are trying to upload is too large. The file must be <b>$kb</b> KB or less.";
                    exit();
              }

              //check file extension
			  $extCheck = $ext; 
              $extCheck = strrchr($_FILES['filetoupload']['name'],'.');
              if (($extlimit == "yes") && (!in_array($extCheck,$limitedext))) {
                    echo("This file type is not supported. Please only upload .jpg, .jpeg, or .png files.");
                    exit();
              }

              // $filename will hold the value of the file name submitted from the form.
              $filename =  $_FILES['filetoupload']['name'];
              // Check if file is Already EXISTS.
              if(file_exists($upload_dir.$filename)){
                    echo "Oops! The file named <b>$filename </b>already exists. <br>»<a href=\"$_SERVER[PHP_SELF]\">back</a>";
                    exit();
              }
					
              //Move the File to the Directory of your choice
              //move_uploaded_file('filename','destination') Moves afile to a new location.
              if (move_uploaded_file($_FILES['filetoupload']['tmp_name'],$upload_dir.$filename)) {
						chmod($upload_dir.$filename, 0604);
                  //tell the user that the file has been uploaded and make him alink.
                  
						return $upload_dir.$filename;
						//echo "File (<a href=$upload_dir$filename>$filename</a>) uploaded! <br>»<a href=\"$_SERVER[PHP_SELF]\">back</a>";
                  //exit();

              }
                  // print error if there was a problem moving file.
                  else
              {
                  //Print error msg.
                  $msg = "There+was+a+problem+moving+your+file.+Please+try+later.";
                  return $msg;
              }
}
?>