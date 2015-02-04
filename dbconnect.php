<?php


function connect(){
	include ('debug.php');
	if ($debug){
		$user = 'root';
		$pass = '';
		$db = 'uwmarketplace';

		$db = mysql_connect('localhost', $user, $pass) or die("Could not connect to database");
		mysql_select_db('uwmarketplace', $db);

	}else{
		$user = 'NOTTHEREALUSER';
		$pass = 'NOTTHEREALPASS';
		$db = 'NOTTHEREALDB';

		$db = mysql_connect('NOTTHEREALHOST', $user, $pass) or die("Could not connect to database");
		mysql_select_db('AINTNOBODYGOTTIMEFODATNOTREAL', $db);
	}
}


function getFields(){

	$postFields = array();
	$result = mysql_query("SHOW COLUMNS FROM posts");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}

	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {

			$field = $row['Field'];
			if ($field!= 'postid'){
				array_push($postFields, $field);
			}
		}
	}

	return $postFields;
}


?>
