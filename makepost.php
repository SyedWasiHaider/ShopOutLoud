
<?php

include 'userpost.php';
include 'dbconnect.php'; 
connect();
/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 * For more versions (one-file, advanced, framework-like) visit http://www.php-login.net
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopOutLoud</title>
 </head>
 <body>
 
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">SOL</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li   ><a  href="index.php">Home</a></li>
        <li class="active"><a style="background-color: #2c2c2c; /* fallback color, place your own */
				color:black;
  /* Gradients for modern browsers, replace as you see fit */
  background-image: -moz-linear-gradient(top, #D9D7D8, #1CF1EA);
  background-image: -ms-linear-gradient(top, #D9D7D8, #1CF1EA);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#D9D7D8), to(#1CF1EA));
  background-image: -webkit-linear-gradient(top, #D9D7D8, #1CF1EA);
  background-image: -o-linear-gradient(top, #D9D7D8, #1CF1EA);
  background-image: linear-gradient(top, #D9D7D8, #1CF1EA);
  background-repeat: repeat-x;

  /* IE8-9 gradient filter */
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#D9D7D8', endColorstr='#1CF1EA', GradientType=0);" href="makepost.php">Post</a></li>
        <li  ><a  href="browse.php">Browse</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search" method="post" action="browse.php">
        <div class="form-group">
          <input name = "search"type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>   <?php
if ($login->isUserLoggedIn() == true) {
echo '<a href="index.php?logout" class="btn btn-default" role="button">
   Log Out</a>';
}else{
echo '<a href="index.php" class="btn btn-default" role="button">
  Sign In</a>';

}	
?> </li>
      
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
  
  <div class="page-header text-center">
    <h1>ShopOutLoud <br>
    <small>The best place to buy and sell stuff!</small>
    </h1>
  </div>
  
</div><!-- /.container -->

 <?php
 

 
 
 if (array_key_exists('title', $_POST)){
 
 $test = new UserPost();
 
 }else{
 
 
 echo '<form enctype="multipart/form-data" class="col-md-4 col-md-offset-4" action="makepost.php" method="post" id="userpost">'  ;


// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
	
	
	
	$postFields = getFields();
	
	$arrSize = sizeof($postFields);
	
	
	 
	 
	 foreach ($postFields as $field){
	 
		if ($field == 'date' || $field =='posterid' ||$field=='picturepath'){ continue; }
	 
		if ($field == 'buyOrSell'){
		
			echo '<select id = "buyOrSell" name="buyOrSell" form="userpost">
					<option value=1>Buying</option>
					<option value=0>Selling</option>
			   </select> ';

		continue;
		}
	 
		if ($field != 'description'){
			echo "<div><label for=".$field.">".strtoupper($field).":".
			"<input class='form-control' type = 'text' name = '".$field."' id = '".$field."'/></label></div>";
		}else{
			echo "<div><label for=".$field.">".strtoupper($field).":".
			"<textarea class='form-control' cols='40' rows='5' type = 'text' name = '".$field."' id = '".$field."'></textarea></label></div>";
		}
	 }
 
 echo 'Photo (Max 2mb): <input type="file" name="picturepath"><br> ';
  echo '<br><br><input class="btn  btn-primary " type="submit" value="Shout"/>'  ;

 echo '</form>';
 }else{
 
 
 echo "<div class='alert alert-danger' role='alert'><a href='index.php'>Login</a> to make a posting, bro!</div>";
 
 
 }
 
 }
?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
 </body>
</html>	