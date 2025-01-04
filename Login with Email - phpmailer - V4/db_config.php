<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database ='login-system';

$conn = mysqli_connect($host,$username,$password,$database);
if (!$conn) {
    $error = "Connection failed: ".mysqli_connect_error();
    }
?>