<?php
	if(!isset($currentCat))
		$currentCat = "";		
	if (isset($_GET["category"]))
		$currentCat = mysql_real_escape_string($_GET["category"]);
		
	$result = mysql_query("SELECT * FROM md_categories order by cat_order");
	if (!$result){    
		print("Houston we have a problem: " . mysql_error());    
		exit();  
	}
		$categoryCounter =0;
		while ($row = mysql_fetch_array($result)){
			if ($currentCat == $row["cat_id"]){
				$id ='id="current"';
				$categoryCounter++;
			}
			$catList .= "<li $id><a href='index.php?category=" . $row["cat_id"] . $keyOut . "'>" . $row["cat_name"] . "</a></li>\n" ;
			$id = "";
		}
		$idNewItem = $idHome = "";
		
	if ($categoryCounter < 1){
		 if(strpos($_SERVER['PHP_SELF'], "newItem") > 0)	
				$idNewItem = "id='current'";
		 else
				$idHome = "current";
	}	
?>
  <div id="headerClassifieds">
  <div style="display:inline; float:right">
  <form name="searchForm" action="index.php" method="get" style="display:inline; float:right">
  <?php echo STR_SEARCH; ?>	<input type="text" name="q" size="8" maxlength="40" value="<?php echo $searchQuery ;?>">
	<input type="submit" name="" value="<?php echo STR_GO; ?>">
  </form>
  </div>
    <ul>
    	<li id='<?php print($idHome); ?>'><a href='index.php?a=1<?php echo $keyOut;?>'><?php echo STR_ALLADDS ?></a></li>
    	<?php print($catList); ?>
		<li <?php print($idNewItem); ?>><a href="newItem.php?a=1<?php echo $keyOut;?>"><?php echo STR_POSTSOMETHING ?></a></li>
    </ul>
  </div>
  <?php mysql_free_result($result); ?>