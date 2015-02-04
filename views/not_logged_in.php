<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {


		echo '<div class="alert alert-danger col-md-4 col-md-offset-4" role="alert">
		<a href="#" class="alert-link">'.$error.'</a>
		</div>';

        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {


		echo '<div class="text-center alert alert-success" role="alert"><a href="#" class="alert-link">'.$message.'</a></div>';

        }
    }
}
?>
	<div class="col-md-4 col-md-offset-4">
<!-- login form box -->
<form class="form-signin" method="post" action="index.php" name="loginform">

    <label for="login_input_username">Username</label>
    <input class="form-control" id="login_input_username" class="login_input" type="text" name="user_name" required />

    <label for="login_input_password">Password</label>
    <input  class="form-control"id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required />
	<br>
    <input class="btn btn-lg btn-primary btn-block" type="submit"  name="login" value="Log in" />

</form>
 </div>
<a class="col-md-4 col-md-offset-4 btn btn-lg btn-link" href="register.php">Register new account</a>
