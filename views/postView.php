
<h3 class ="text-center">My Posts<span class=" label label-default"></span></h3>

	<div class="well center-block row container-fluid">

<?php

	if(empty($_SESSION)){session_start();}

	$result = mysql_query("select * FROM posts  where posterid='".$_SESSION['user_id']."' order by date DESC");
	$index = 0;
	if (mysql_num_rows($result) > 0) {

		while ($index < 9 and $row = mysql_fetch_assoc($result)) {



			if ($row['buyOrSell']){

				$sellorbuy="[BUYING]";


			}else{

				$sellorbuy="[SELLING]";

			}

			$description = $row['description'];

			if (strlen($description) > 300){
				$description = substr($description, 0, 280)."...";

			}


			if (!empty($row['picturepath'])){
				echo '<div class="thumbnail col-sm-6 col-md-4"> <img style="width: 150px; height: 150px;" src="images/'.$row['posterid']."/".$row['picturepath'].'" alt="..."> <div class="caption"><h3>'.$sellorbuy.' '.$row['title'].'</h3><p style="word-wrap: break-word;">'.$description.'</p><p><a href="singlePostView.php?postid='.$row['postid'].'" class="btn btn-primary" role="button">More</a></p></div> </div>';
			}else{
				echo '<div class="thumbnail col-sm-6 col-md-4">  <img style="width: 150px; height: 150px;" src="http://lorempixel.com/200/200/abstract" alt="..."> <div class="caption"><h3>'.$sellorbuy.' '.$row['title'].'</h3><p style="word-wrap: break-word;" >'.$description.'</p><p><a href="singlePostView.php?postid='.$row['postid'].'" class="btn btn-primary" role="button">More</a></p> </div> </div>';
			}

			$index = $index + 1;
		}

	}else{


		$message = "Hmm...You have no posts! Make one <a href='makepost.php'>here<a/>";
		echo '<div class="text-center alert alert-warning" role="alert"><a href="#" class="alert-link">'.$message.'</a></div>';

	}


?>
</div>
