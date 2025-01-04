<!-- verify.php -->
<?php
include 'db_config.php';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    // التحقق من صحة الرمز وصلاحيته
    $current_time = date('Y-m-d H:i:s');
    $sql_check_token = "SELECT * FROM users WHERE email = '$email' AND token = '$token' AND token_expiration > '$current_time'";
    $result_check_token = mysqli_query($conn, $sql_check_token);

    if (mysqli_num_rows($result_check_token) === 1) {
        // تأكيد الحساب
        $sql_confirm_account = "UPDATE users SET token = NULL, token_expiration = NULL WHERE email = '$email'";
        if (mysqli_query($conn, $sql_confirm_account)) {
            $success = 'تم تأكيد الحساب بنجاح!';
        } else {
            $error = 'حدث خطأ أثناء تأكيد الحساب. يُرجى المحاولة مرة أخرى.';
        }
    } else {
        $error = 'رمز التحقق غير صالح أو انتهت صلاحيته.';
    }
} else {
    $error = 'رابط التحقق غير صالح.';
}
?>
