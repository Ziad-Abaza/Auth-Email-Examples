<?php
require 'auth.php';
include 'db_config.php';

if (isset($_POST["register"])) {
    $username = $_POST['username'];
    $email = strtolower($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    $sql_check_username = "SELECT * FROM users WHERE username = '$username'";
    $result_check_username = mysqli_query($conn, $sql_check_username);

    if (mysqli_num_rows($result_check_email) > 0) {
        $row = mysqli_fetch_assoc($result_check_email);
        $verify = $row['verify'];
        $stored_token = $row['token'];
        if($verify==0){
        send_email($email, $stored_token);
        echo "<script>alert('this email was registired we've sent you another verification link');location.href='index.html';</script>";exit;}
    else{echo "<script>alert('This email is already used please use another email');location.href='index.html';</script>";exit;}

    } elseif (mysqli_num_rows($result_check_username) > 0) {
        echo "<script>alert('This username is already used please use another email');location.href='index.html';</script>";exit;
    } else {
        $verificationToken = generateUserVerificationToken($email);
        $sql_insert_user = "INSERT INTO users (username, email, password, token) VALUES ('$username', '$email', '$password','$verificationToken')";
        if (mysqli_query($conn, $sql_insert_user)) {
            send_email($email, $verificationToken);
            header("Location: index.html?email=$email");
        } else {
            echo 'حدث خطأ أثناء إنشاء الحساب. يرجى المحاولة مرة أخرى.';
        }
    }
}
?>
