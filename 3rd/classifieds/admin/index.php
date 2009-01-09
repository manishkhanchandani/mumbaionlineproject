<?php include_once("inc_header.php");
	  include_once("../inc_dbcon.php");
	  //include_once("password.php");
	  include_once("config.php");
 ?>
<html>
<head>
<title>Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="md_admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1 class="title">Market Admin</h1>
<p><a href="categories.php"><img src="../images/bullet.gif" width="16" height="16" hspace="6"  border="0" align="absmiddle"></a> 
  <a href="categories.php"><strong>Edit Categories</strong></a> - Create, Edit, 
  Delete categories.&nbsp; </p>
<p><a href="../index.php?k=<?php echo $key; ?>"><img src="../images/bullet.gif" width="16" height="16" hspace="6"  border="0" align="absmiddle"></a> 
  <a href="../index.php?k=<?php echo $key; ?>"><strong>View 
  Site in Admin Mode</strong></a> - This allows you to view postings with a <strong>delete</strong> 
  button on it. </p>
<p><img src="../images/bullet.gif" width="16" height="16" hspace="6"  border="0" align="absmiddle"> 
  <strong>config.php:</strong>
<blockquote> 
  <p><strong> </strong>Be sure these reflect where your server:<br>
    <br>
    $emailAdmin = <strong><?php echo $emailAdmin; ?></strong> <br>
    $languageFile = <strong><?php echo $languageFile; ?></strong><br>
    $urlPath = <strong><?php echo $urlPath; ?></strong><br>
  </p>
</blockquote>
</body>
</html>
