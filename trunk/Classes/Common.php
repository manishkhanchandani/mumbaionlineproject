<?php
class Common {
	
	function __construct() {
	
	}
	
	public function display_table_fields_sql($sql) {
		$rs =mysql_query($sql." LIMIT 1");
		$i = 0;
		$register_main_arr = array();
		while ($i < mysql_num_fields($rs)) {
			$meta = mysql_fetch_field($rs, $i);
			$register_arr[] = $meta->name;
			$i++;
		}
		return $register_arr;
	}
	
	public function display_table_fields($table_name) {
		$rs =mysql_query("select * from ".$table_name." LIMIT 1");
		$i = 0;
		$register_main_arr = array();
		while ($i < mysql_num_fields($rs)) {
			$meta = mysql_fetch_field($rs, $i);
			$register_arr[] = $meta->name;
			$i++;
		}
		return $register_arr;
	}
	
	public function insert($table_name, $pk, $postarray) {
		$register_arr = array();
		$register_arr = $this->display_table_fields($table_name);
		$sql = "INSERT into ".$table_name."(".$pk.") VALUES ('')";
		
		$rs = mysql_query($sql);
		$uid = mysql_insert_id();
		$query = "UPDATE  ".$table_name." SET ";
		foreach($postarray as $key=>$value) {
			if(gettype($value)=="array") {
				$string = '';
				foreach($value as $val) {
					if(strlen($val)>0) { 
						$val = addslashes(stripslashes(trim($val)));
						$string .= $val.'|';
					}
				}
				$string = substr($string,0,-1);
				if(in_array($key,$register_arr)) {
					$query .= $key."='".$string."',"; 
				}
			} else {
				if(in_array($key,$register_arr)) {
					$value = addslashes(stripslashes(trim($value)));
					$query .= $key."='".$value."',";
				}
			}
		}
		$query = substr($query,0,-1);
		$query .= " WHERE ".$pk." = '".$uid."'"; 
		$result = mysql_query($query);
		$this->uid = $uid;
		return $uid;
	}
	
	public function edit($table_name, $pk, $postarray, $uid) {
		$register_arr = array();
		$register_arr = $this->display_table_fields($table_name);
		$query = "UPDATE ".$table_name." SET ";
		foreach($postarray as $key=>$value) {
			if(gettype($value)=="array") {
				$string = '';
				foreach($value as $val) {
					if(strlen($val)>0) { 
						$val = addslashes(stripslashes(trim($val)));
						$string .= $val.'|';
					}
				}
				$string = substr($string,0,-1);
				if(in_array($key,$register_arr)) {
					$query .= $key."='".$string."',"; 
				}
			} else {
				if(in_array($key,$register_arr)) {
					$value = addslashes(stripslashes(trim($value)));
					$query .= $key."='".$value."',";
				}
			}
		}
		$query = substr($query,0,-1);
		$query .= " WHERE ".$pk." = '".$uid."'";
		$result = mysql_query($query);
		return $uid;
	}
	
	public function getRecords($sql, $max="10000000000", $totalRows="", $pageNum=0, $orderby="", $order="") {
		if($orderby) $sql .= " order by ".$orderby." ";
		if($order) $sql .= $order;
		$return['sql'] = $sql;
		$return['max'] = $max;
		$return['pageNum'] = $pageNum;
		
		$start = $pageNum * $max;
		$return['start'] = $start;
		
		$return['orderby'] = $orderby;
		$return['order'] = $order;
		
		$query = $sql;
		$query_limit = sprintf("%s LIMIT %d, %d", $query, $start, $max);
		$return['query_limit'] = $query_limit;
		$rs = mysql_query($query_limit);
		
		if ($totalRows) {
		  
		} else {
		  $all_rs = mysql_query($query);
		  $totalRows = mysql_num_rows($all_rs);
		}
		$return['totalRows'] = $totalRows;
		$totalPages = ceil($totalRows/$max)-1;
		$return['totalPages'] = $totalPages;
		
		if ($totalRows > 0) {
			while ($row = mysql_fetch_array($rs)) {
				$details[] = $row;
			} 
		}
		$return['details'] = $details;
		return $return;
	}
	
	public function query($sql) {
		mysql_query($sql);
	}
	
	public function validate($validation, $post) {
		$return['is_error'] = 0;
		$return['error_message'] = '';
		if($validation) {
			foreach($validation as $k=>$v) {
				switch($v['type']) {
					case 'required':
						if(!trim($post[$k])) {
							$return['is_error'] = 1;
							$return['error_message'] .= "<p class=\"error\">".$v['label']." is required.</p>";
						}
						break;
				}
			}
		}
		return $return;
	}
	
	public function emailvalidity($email) {
		if (eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $email)) {
			// this is a valid email domain!
			return 1;
		}
		return 0;
	}
	
	public function emailSimple($to,$subject,$message,$headers) {
		if(@mail($to, $subject, $message, $headers)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function emailHTML($to,$subject,$message,$additional) {
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $additional;
		if(@mail($to, $subject, $message, $headers)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function make_url_lookup($input) {
		$input = trim($input);
		$url_lookup = strip_tags($input);
		$url_lookup = str_replace(" ", "-", $url_lookup);
		$url_lookup = str_replace("&amp", "and", $url_lookup);
		$url_lookup = ereg_replace("[^a-zA-Z0-9]+", "-", $url_lookup);
		$url_lookup = ereg_replace("-+$", "", $url_lookup);
		$url_lookup = strtolower($url_lookup);
		return $url_lookup;
	}
	
	public function getThumbnailSize($ex_width, $ex_height, $maxheight=80, $maxwidth=80) {
		if($ex_width >= $ex_height){  
			if($ex_width > $maxwidth){   
				$ds_width_ex  = $maxwidth;   
				$ratio_ex     = $ex_width / $ds_width_ex;  
				$ds_height_ex = $ex_height / $ratio_ex;
				$ds_height_ex = round($ds_height_ex);  
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height;   
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			}  
		} else {  
			if($ex_height > $maxheight){  
				$ds_height_ex = $maxheight;
				$ratio_ex     = $ex_height / $ds_height_ex;
				$ds_width_ex  = $ex_width / $ratio_ex;
				$ds_width_ex  = round($ds_width_ex);  
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height; 
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			}  
		}  
		$size['width'] = $ds_width_ex;
		$size['height'] = $ds_height_ex;
		return $size;
	}
	public function buildThumbnail($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
	  
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		@imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
	}
	public function buildThumbnailWithoutResize($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		//$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
		$size['width'] = $maxwidth;
		$size['height'] = $maxheight;
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
	}
	
	public function getExtension($img) {
		$ext = substr(strrchr($img, '.'), 1);
		return $ext;
	}
	
	public function cropImage($get, $finalwidth, $finalheight) {
		// get variables
		$imgfile = $get['image'];
		$cropStartX = $get['cropStartX'];
		$cropStartY = $get['cropStartY'];
		$cropW = $get['cropWidth'];
		$cropH = $get['cropHeight'];
		$format = strtolower($this->getExtension($imgfile));
		$dest = $get['dest'];
		
		// Create two images
		if($format=="png") {
			$origimg = @imagecreatefrompng($imgfile);
		} else if($format=="jpg") {
			$origimg = @imagecreatefromjpeg($imgfile);	
		} else if($format=="gif") {
			$origimg = @imagecreatefromgif($imgfile);	
		}
		$cropimg = imagecreatetruecolor($finalwidth,$finalheight);
	
		// Get the original size
		//list($width, $height) = getimagesize($imgfile);
	
		// Crop
		imagecopyresampled($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $finalwidth, $finalheight, $cropW, $cropH);
	
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($cropimg, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($cropimg, $dest, 90);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($cropimg, $dest);
		}
		@imagedestroy($cropimg);
	}
	
	
	public function getPerPage($getMax, $cookieMax, $total) {
		if($getMax) { 
			if($getMax == -1) {
				$perPage = $total;
			} else {
				$perPage = $getMax; 
			}
			setcookie('maxRows',$getMax,time()+(60*60*24*365),'/');
		} else if($cookieMax) {
			if($cookieMax == -1) {
		    if($total) {
  				$perPage = $total;
  		  }
  		  else {
  		    $perPage = 9999;
  		  }
			} else {
				$perPage = $cookieMax; 
			}
		} else {
			$perPage = 10;
		}
		return $perPage;
	}
	public function getShowOptions($get, $cookie) {
		if($get) $sel = $get; 
		else if($cookie) $sel = $cookie;
		
		$options = '<option value="10"';
		if($sel==10) $options .= " selected";
		$options.= '>10 </option>';
		$options.='<option value="20"';
		if($sel==20) $options.= " selected";
		$options.= '>20</option>';		
		$options.='<option value="30"';
		if($sel==30) $options.= " selected";
		$options.= '>30</option>';	
		$options.='<option value="40"';		
		if($sel==40) $options.= " selected";
		$options.= '>40</option>';
		$options.='<option value="50"';
		if($sel==50) $options.= " selected";
		$options.= '>50</option>';
		$options.='<option value="-1"';	
		if($sel=='-1') $options.= " selected";
		$options.= '>All</option>';	
		return $options;
	}
	
	public function getQueryString($totalRows="") {
		$queryString = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "maxRows") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString = "&" . implode("&", $newParams);
		  }
		}
		$queryString = sprintf("%s", $queryString);
		return $queryString;
	}
	
	public function getQueryStringRemoveDown() {
		$queryString = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "dir") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString = "&" . implode("&", $newParams);
		  }
		}
		$queryString = sprintf("%s", $queryString);
		return $queryString;
	}
	
	public function getQueryStringSorting() {
		$queryString = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "order") == false && stristr($param, "orderby") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString = "&" . implode("&", $newParams);
		  }
		}
		$queryString = sprintf("%s", $queryString);
		return $queryString;
	}
	
}
?>