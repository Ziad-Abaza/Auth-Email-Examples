<?php
include "db_config.php";

if (isset($_POST["login"])) {
    $username = $_POST['username_login'];
    $password = $_POST['password_login'];
    $email = strtolower($username);

    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    $sql_check_username = "SELECT * FROM users WHERE username = '$username'";
    $result_check_username = mysqli_query($conn, $sql_check_username);

    if ((mysqli_num_rows($result_check_email) > 0) || (mysqli_num_rows($result_check_username) > 0)) {
        if (mysqli_num_rows($result_check_email) > 0) {
            $row = mysqli_fetch_assoc($result_check_email);
        } else if (mysqli_num_rows($result_check_username) > 0) {
            $row = mysqli_fetch_assoc($result_check_username);
        }
        
        $hashedPassword = $row['password'];
        
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $user = $row['username'];
            $_SESSION['username'] = $user;
            header("Location: user.php");
            exit(); 
        } else {echo "<script>alert('Wrong username or password');location.href='index.html';</script>";exit;}
        
        $verify = $row['verify'];
    }
}
?>
