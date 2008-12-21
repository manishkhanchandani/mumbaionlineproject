<?php
class ratequality {
	public $cacheSecs = 300;
	private static $instance;
	
	function __construct($dbFrameWork) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
		}
	}
	
	private function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
	
	public function deleteProfile($id) {
  		$sql = sprintf("SELECT * FROM rate_my_qualities WHERE id=%s",
                       $this->GetSQLValueString($id, "int"));
  		$Result1 = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$row = $Result1->FetchRow();
  		@unlink("images/".$row['id']."_".$row['photo']);
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities WHERE id=%s",
                       $this->GetSQLValueString($id, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities_relation WHERE id=%s",
                       $this->GetSQLValueString($id, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities_vote WHERE id=%s",
                       $this->GetSQLValueString($id, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities WHERE id=%s",
                       $this->GetSQLValueString($id, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		return true;
	}
	
	public function deleteQuality($qid) {
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities_question WHERE qid=%s",
                       $this->GetSQLValueString($qid, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities_relation WHERE qid=%s",
                       $this->GetSQLValueString($qid, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		
		$deleteSQL = sprintf("DELETE FROM rate_my_qualities_vote WHERE qid=%s",
                       $this->GetSQLValueString($qid, "int"));
  		$Result1 = $this->dbFrameWork->Execute($deleteSQL);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		return true;
	}
	
	public function addProfile($post, $files) {
		if ((isset($post["MM_insert"])) && ($post["MM_insert"] == "form1")) {
			if(!trim($post['name'])) {
				unset($post["MM_insert"]);
				$msg = "<p class='error'>Please fill the name.</p>";
			}
			$post['photo'] = $files['image']['name'];
		}
		if ((isset($post["MM_insert"])) && ($post["MM_insert"] == "form1")) {
		  $insertSQL = sprintf("INSERT INTO rate_my_qualities (user_id, name, photo) VALUES (%s, %s, %s)",
							   $this->GetSQLValueString($post['user_id'], "int"),
							   $this->GetSQLValueString($post['name'], "text"),
							   $this->GetSQLValueString($post['photo'], "text"));
		  $Result1 = $this->dbFrameWork->Execute($insertSQL);
		    if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}
		}
		
		
		if ($post["MM_insert"] == "form1") {
			$id = mysql_insert_id();
			if($files) {
				$dir = DOCROOT."/modules/ratemyquality/images/";
				$filename = $id."_".$files['image']['name'];
				move_uploaded_file($files['image']['tmp_name'], $dir.$filename);
			}
			$msg = "<p class='error'>Profile Created Successfully.</p>";
		}
		return $msg;
	}
	
	public function updateRelation($post) {
		$sql = "delete from rate_my_qualities_relation where id = '".$post['id']."'";
		$this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		if($post['qid']) {
			foreach($post['qid'] as $k=>$v) {
				$sql = "insert into rate_my_qualities_relation set qid = '".$v."', id = '".$post['id']."'";
				$this->dbFrameWork->Execute($sql);
				if($this->dbFrameWork->ErrorMsg()) {
					throw new Exception($this->dbFrameWork->ErrorMsg());
				}
			}
		}
		$msg = "<p class='error'>Relation Updated Successfully.</p>";
		return $msg;
	}
}
?>