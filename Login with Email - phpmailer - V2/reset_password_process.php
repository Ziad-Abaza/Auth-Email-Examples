<!-- reset_password_process.php -->
<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // البريد الإلكتروني المُدخل في النموذج
    $token = $_POST['token']; // رمز إعادة تعيين كلمة المرور المُدخل في النموذج
    $new_password = $_POST['new_password']; // كلمة المرور الجديدة المُدخلة في النموذج
    $confirm_password = $_POST['confirm_password']; // تأكيد كلمة المرور الجديدة المُدخلة في النموذج

    if ($new_password !== $confirm_password) {
        // التحقق من أن تأكيد كلمة المرور تطابق كلمة المرور الجديدة
        echo 'تأكيد كلمة المرور لا يتطابق مع كلمة المرور الجديدة. يُرجى المحاولة مرة أخرى.';
        exit;
    }

    // التحقق من صحة رمز إعادة تعيين كلمة المرور وصلاحيته
    $current_time = date('Y-m-d H:i:s'); // الوقت الحالي
    $sql_check_reset_token = "SELECT * FROM users WHERE email = '$email' AND token = '$token' AND token_expiration > '$current_time'";
    $result_check_reset_token = mysqli_query($conn, $sql_check_reset_token);

    if (mysqli_num_rows($result_check_reset_token) === 1) {
        // إذا كان رمز إعادة تعيين كلمة المرور صالحًا، قم بتغيير كلمة المرور
        $sql_reset_password = "UPDATE users SET password = '$new_password', token = NULL, token_expiration = NULL WHERE email = '$email'";
        if (mysqli_query($conn, $sql_reset_password)) {
            // تم تغيير كلمة المرور بنجاح
            echo 'تم تغيير كلمة المرور بنجاح!';
        } else {
            echo 'حدث خطأ أثناء تغيير كلمة المرور. يُرجى المحاولة مرة أخرى.';
        }
    } else {
        // إذا كان رمز إعادة تعيين كلمة المرور غير صالح أو انتهت صلاحيته
        echo 'رمز إعادة تعيين كلمة المرور غير صالح أو انتهت صلاحيته.';
    }
}
?>
