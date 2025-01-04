<?php
include 'db_config.php';

if (isset($_GET['token']) && isset($_GET['email'])) {
    $verificationToken = $_GET['token'];
    $email = $_GET['email'];
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);
    if ($result_check_email) {
        if (mysqli_num_rows($result_check_email) > 0) {
            // Email exists in the database, you can compare the token here
            $row = mysqli_fetch_assoc($result_check_email);
            $storedToken = $row['token'];

            if ($verificationToken === $storedToken) {
                // Token matches, perform your verification logic here
                
                // For example, you can update the user's verification status in the database
                $sql_update_verification = "UPDATE users SET verify = 1 WHERE email = '$email'";
                mysqli_query($conn, $sql_update_verification);
                
                // Display a success message or redirect the user
                echo "<script>alert('Email Verified Successfully!');location.href='index.html';</script>";exit;}
            else{echo "<script>alert('Verification Link Expired or Invalid');location.href='index.html';</script>";exit;}}
            else{echo "<script>alert('Verification Link Expired or Invalid');location.href='index.html';</script>";exit;}}
            else{echo "<script>alert('Verification Link Expired or Invalid');location.href='index.html';</script>";exit;}
        }
?>
