<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    function Send_Mail($to,$subject,$body)
{

require 'class.phpmailer.php';
require_once('class.smtp.php');
$from       = "FAKEFAKEFAKE";
$mail       = new PHPMailer();
$mail->IsSMTP(true);            // use SMTP
$mail->IsHTML(true);
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = 'FAKEFAKEFAKE'; // SMTP host
$mail->Port       =  465;                    // set the SMTP port
$mail->Username   = "FAKEFAKEFAKE";  // SMTP  username
$mail->Password   = "FAKEFAKEFAKESHAKE";  // SMTP password
$mail->SetFrom($from, 'Wasi');
$mail->AddReplyTo($from,'Wasi');
$mail->Subject    = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);

try {
 if($mail->Send()){

}else{
echo "Could not send mail to ".$to;
//delete query here
}
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //error messages from PHPMailer
}catch (Exception $e){

//delete query here
}
}

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {

         require_once('recaptchalib.php');
	$privatekey = "FAKEFAKEFAKE";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		$this->errors[] = "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
	}elseif (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];
			$options = [
			'cost' => 13,
			];
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, $options);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
		    $activation=md5($user_email.time()); // encrypted email+timestamp
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email, activation, active)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '".$activation."', 0);";
                    $query_new_user_insert = $this->db_connection->query($sql);

		   $base_url = "http://www.wasi.byethost24.com/";


                    // if user has been added successfully
                    if ($query_new_user_insert) {

		$to=$user_email;
		$subject="ShopOutLoud Email verification";
		$body='Hey '.$user_name.', <br/> <br/> Thanks for registering your ShopOutLoud account. To login and start making posts, click on this link to verify your email and finally start using your account! <br/> <br/> <a href="'.$base_url.'activation/'.$activation.'">'.$base_url.'activation/'.$activation.'</a> <br> <br> Hope you like the website, <br> Wasi (ShopOutLoud Admin)';

		$this->Send_Mail($to,$subject,$body);


		    $this->messages[] = "Your account has been created successfully. To start using your account, check your email/junk for the activation code.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
			  $sql = "Delete from users where user_name='" . $user_name . "' and user_email = '". $user_email . "');";
			   $query_new_user_delete = $this->db_connection->query($sql);
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection. Please contact the admin.";
            }
        } else {
            $this->errors[] = "An unknown error occurred. Please contact the admin.";
        }



    }





}
