<?php
    error_reporting(0);
    $msg = "";
    $msg1="";
	use PHPMailer\PHPMailer\PHPMailer;
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database ='login-system';

	if (isset($_POST['submit'])) {
        $conn = mysqli_connect($host,$username,$password,$database);

		$name = $con->real_escape_string($_POST['name']);
		$email = $con->real_escape_string($_POST['email']);
		$password1 = $con->real_escape_string($_POST['password']);
		// $password2 = $con->real_escape_string($_POST['cPassword']);

		// if ($name == "" || $email == "" || $password1 != $password2)
		// 	$msg = "<div class='alert alert-dismissible alert-warning'>
        //     <button type='button' class='close' data-dismiss='alert'>&times;</button>
        //     Please check your inputs.
        //   </div>";
		// else {


            $conn = mysqli_connect($host,$username,$password,$database);
            $sql = "SELECT id FROM users WHERE email='$email'";
            $result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) {
				$msg = "<div class='alert alert-dismissible alert-warning'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                Email already exists in database.
              </div>";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password1, PASSWORD_BCRYPT);
                $conn = mysqli_connect($host,$username,$password,$database);
				$sql = "INSERT INTO users (firstName,email,password,isEmailConfirmed,token,keyToken)
                VALUES ('$name', '$email', '$hashedPassword', '0', '$token','')";
                if (mysqli_query($con, $sql)) {
                    $msg = "Registration complete. Please check your email.";
                }
                
                include_once "PHPMailer/PHPMailer.php";

                $mail = new PHPMailer();
                $mail->Username = "IT.club.BATU@gmail.com"; // Replace with your custom "From" address
                $mail->Password = "acthvgcxuwuduxbp"; // Replace with your email password
                $mail->setFrom('IT.club.BATU@gmail.com');
                $mail->addAddress($email, $name);
                $mail->Subject = "Please verify email!";
                $mail->isHTML(true);
                $mail->Body = "Hello $name, <br>
                    Please click on the link below to confirm your email.<br><br>
                    
                    <a href='http://phplogsys.000webhostapp.com/confirm.php?email=$email&/verify.php?token=$token'>Confirm email</a>
                ";

                if ($mail->send())
                    $msg = "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Registration complete !</strong> Please check your email for confirmation.
                  </div>";
                else
                    $msg = "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Something wrong happened</strong> Please try again.
                  </div>";
			}
        // }
        $con->close();
	}
?>