<html>

  <head>


  <meta charset="utf-8"></meta>

<meta content="IE=edge" http-equiv="X-UA-Compatible"></meta>

<meta content="width=device-width, initial-scale=1" name="viewport"></meta>


 <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
</head>

<body>


<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="makepost.php">Post</a></li>
        <li><a href="browse.php">Browse</a></li>
      </ul>

    </div><!--/.nav-collapse -->
  </div>
</div>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo '<div class="text-center alert alert-danger" role="alert">'.$error.'</div>';
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
                     echo '<div class="text-center alert alert-success" role="alert">'.$message.'</div>';
        }
    }
}
?>


 <div class="col-md-4 col-md-offset-4 container"
<!-- register form -->
<form role="form" class='form-signin' method="post" action="register.php" name="registerform">

    <!-- the user name input field uses a HTML5 pattern check -->
    <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
    <input id="login_input_username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

    <!-- the email input field uses a HTML5 email type check -->
    <label for="login_input_email">User's email</label>
    <input id="login_input_email" class="form-control" type="email" name="user_email" required />

    <label for="login_input_password_new">Password (min. 6 characters)</label>
    <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="login_input_password_repeat">Repeat password</label>
    <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />


      <script type="text/javascript"
       src="http://www.google.com/recaptcha/api/challenge?k=6LcVavYSAAAAAHAOV6tq59DF7PDUbRasjqTpeVxZ">
    </script>
    <noscript>
    <div  class="control-group" align="center" id="recaptcha_area">
       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcVavYSAAAAAHAOV6tq59DF7PDUbRasjqTpeVxZ"
           height="300" width="500" frameborder="0"></iframe></div><br>
       <textarea name="recaptcha_challenge_field" rows="3" cols="40">
       </textarea>
       <input type="hidden" name="recaptcha_response_field"
           value="manual_challenge">
    </noscript>

    <br>
 <input class="btn btn-lg btn-primary btn-block" type="submit"  name="register" value="Register" />

</form>

<br>
<a class="row btn btn-lg btn-link" href="index.php">Back to Login Page</a>

</div>
<!-- backlink -->

</body>

</html>
