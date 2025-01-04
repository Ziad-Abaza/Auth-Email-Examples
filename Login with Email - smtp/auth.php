<?php
function generateVerificationToken()
{
    return bin2hex(random_bytes(32)); // Generate a 64-character hexadecimal token
}

function generateUserVerificationToken($email)
{
    return generateVerificationToken();
}

function send_email($email, $verificationToken)
{
    require 'smtp/PHPMailerAutoload.php';

    $site = "localhost/reg";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Username = "IT.club.BATU@gmail.com";
    $mail->Password = "acthvgcxuwuduxbp";
    $mail->SetFrom("IT.club.BATU@gmail.com");
    $mail->AddAddress($email);

    $mail->addReplyTo("IT.club.BATU@gmail.com");

    $verificationLink = $site . "/verify.php?email=" . $email . "&token=" . $verificationToken;

    $msg = "<p>Click the following link to verify your email:</p>";
    $msg .= "<p><a href='$verificationLink'>click here</a></p>";

    $mail->Subject = 'Email Verification';
    $mail->Body = $msg;

    $plainTextMsg = "Click the following link to verify your email:\n$verificationLink";
    $mail->AltBody = $plainTextMsg;

    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        echo "<script>alert('A verification link has been sent to your email.'); window.location.href='index.html';</script>";
        exit;
    }
}
?>
