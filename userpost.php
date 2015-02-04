<html>
 <head>
  <title>ShopOutLoud</title>
 </head>
 <body>
<?php  
 class UserPost{
 
 
  function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 
 
 
 function makeQuery($actualPic){
 
	$postFields = getFields();
		$arrSize=sizeof($postFields);

 $index = 0;
	$sqlQuery = "Insert into posts (";
	foreach($postFields as $fields){
		
		if ($index == $arrSize - 1){
			$sqlQuery = $sqlQuery.$fields.") Values (";
		}else{
			
			$sqlQuery = $sqlQuery.$fields.",";
			
		}
		
		$index++;
	}
	 $index=0;
	 $badInput = false;
	 
	 	
			
		 //Writes the information to the database 
	 
	foreach($postFields as $fields){
		
			if ($fields == 'posterid'){
				if(!isset($_SESSION)){session_start();}
				$sqlQuery = $sqlQuery."'".$_SESSION['user_id']."'";
			}elseif ($fields == 'date'){
				
				$today = getdate();
				
				$sqlQuery = $sqlQuery."'".$today["year"]."-".$today["mon"]."-".$today["mday"]." ".$today["hours"].":".$today["minutes"].":".$today['seconds']."'";
			}else{
				if ($fields != 'buyOrSell' and $fields != 'picturepath'){ 
					if (empty($_POST[$fields])){ $badInput = true; break;}
				}
					if ($fields=='picturepath'){
						$sqlQuery = $sqlQuery."'".$actualPic."'";
					}else{
						$sqlQuery = $sqlQuery."'".$_POST[$fields]."'";
					}
			}
			
			if ($index == $arrSize - 1){
				
					$sqlQuery = $sqlQuery.");";
				
			}else{
				$sqlQuery = $sqlQuery.",";
			}
		
		
		$index++;
	}
	
	
		if ($badInput){ 
		
			
			echo '<div class="text-center alert alert-danger" role="alert">Something went wrong. Panic! Make sure you fill out all the fields or risk failure in your life. Try <a href="makepost.php">again</a></div>';
			die();
			
		
		}else{
		
			return $sqlQuery;
		
		}
 
 
 
 }
 
  public function __construct() { 

	//This is the directory where images will be saved 
		$target = "images/".$_SESSION['user_id']."/"; 
		$target = $target . basename( $_FILES['picturepath']['name']); 
		
		$pic=($_FILES['picturepath']['name']);
	
	
		$query = $this->makeQuery($pic);
		
	
		if (!empty($pic)){
		 if ($pic==".htaccess" or $_FILES['picturepath']['size'] > 2097152){echo "Your file was invalid or too big (max 2mb)."; die();}
		
			if(!file_exists("images/".$_SESSION['user_id']) and !mkdir("images/".$_SESSION['user_id'], 0700)){ echo "You image folder could not be created on the server"; die();}
			
			
			if (file_exists($target)){
			
			
				while(file_exists($target)){
				
				
					$pic = ((string)rand(0, mt_getrandmax())).($_FILES['picturepath']['name']);
					$target = "images/".$_SESSION['user_id']."/".$pic; 
				
				}
				
				$query = $this->makeQuery($pic);
				
				
				
			}
			
				//Writes the photo to the server 
			if(!empty($pic) and !move_uploaded_file($_FILES['picturepath']['tmp_name'], $target)) 
			{ 
				echo '<div class="text-center alert alert-danger" role="alert"> I could not upload. Ensure you a valid image (max 2mb)'.$pic.'</div>'; 
			}
		
			
		 }
			
		 
				if(mysql_query($query)){
					echo '<div class="text-center alert alert-success" role="alert">Your AD was sucessfully added to the listings. Go <a href="browse.php">check!</a> </div>';
				}else{
					
					echo '<div class="text-center alert alert-danger" role="alert">Something went wrong with the database query. Try <a href="makepost.php">again</a></div>';
					
				}
			
	

	}


  }
  
	


?>
	
	
	 </body>
</html>	