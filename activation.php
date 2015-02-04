<?php
include ('dbconnect.php'); connect();

$msg='';
if(!empty($_GET['code']) && isset($_GET['code']))
{

$code = $_GET['code'];
$c=mysql_query("SELECT user_id FROM users WHERE activation='".$code."'");

if(mysql_num_rows($c) > 0)
{
$count=mysql_query("SELECT user_id FROM users WHERE activation='".$code."' and active='0'");

if(mysql_num_rows($count) == 1)
{
mysql_query("UPDATE users SET active='1' WHERE activation='".$code."'");
$msg='<div class="alert alert-success col-md-4 col-md-offset-4" role="alert">Your account is activated. <a href="../index.php">Login</a></div>';
}
else
{
$msg ='<div class="alert alert-warning col-md-4 col-md-offset-4" role="alert">Your account is already active, no need to activate again. <a href="../index.php">Login</a></div>';
}

}
else
{
$msg ='<div class="alert alert-danger col-md-4 col-md-offset-4" role="alert">Wrong activation code.</div>';
}

}


?>

<html>
 <head>
 <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
 <link rel="stylesheet" href="css/animate.css">
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
        <li><a  href="../index.php">Home</a></li>
        <li><a href="../makepost.php">Post</a></li>
        <li><a href="../browse.php">Browse</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search" method="post" action="../browse.php">
        <div class="form-group">
          <input name = "search"type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">


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

<?php echo $msg ?>

</body>

</html>
