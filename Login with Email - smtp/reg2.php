<?php
if (isset($_POST["register"])) {
    $username = $_POST['username'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];}

echo $username;
echo $email;
echo $password;
    ?>