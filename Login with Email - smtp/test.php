<?php
include 'db_config.php';

$userInputPassword = "omar5040";
$sql_check_email = "SELECT * FROM users WHERE email = 'omeralgamel@gmail.com'";
$result_check_email = mysqli_query($conn, $sql_check_email);
if (mysqli_num_rows($result_check_email) > 0) {
    $row = mysqli_fetch_assoc($result_check_email);
    $hashedPassword = $row['password'];
    echo "Stored Hashed Password: $hashedPassword<br>";



if (password_verify($userInputPassword, $hashedPassword)) { echo "yes";}
else{echo "NO";}}

    ?>