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
        // تأكيد الحساب وتحديث الخانة is_active إلى 1
        $sql_confirm_account = "UPDATE users SET token = NULL, token_expiration = NULL, is_active = 1 WHERE email = '$email'";
        if (mysqli_query($conn, $sql_confirm_account)) {
            echo 'تم تأكيد الحساب بنجاح!';
        } else {
            echo 'حدث خطأ أثناء تأكيد الحساب. يُرجى المحاولة مرة أخرى.';
        }
    } else {
        echo 'رمز التحقق غير صالح أو انتهت صلاحيته.';
    }
} else {
    echo 'رابط التحقق غير صالح.';
}
?>
