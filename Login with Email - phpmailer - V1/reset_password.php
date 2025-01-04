<!-- reset_password.php -->
<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // التحقق من وجود حساب مستخدم بالبريد الإلكتروني المدخل
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) === 1) {
        // إنشاء رمز عشوائي لإعادة تعيين كلمة المرور
        $reset_token = bin2hex(random_bytes(32));
        $reset_token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // حفظ رمز إعادة تعيين كلمة المرور في قاعدة البيانات
        $sql_save_reset_token = "UPDATE users SET token = '$reset_token', token_expiration = '$reset_token_expiration' WHERE email = '$email'";
        if (mysqli_query($conn, $sql_save_reset_token)) {
            // إرسال رابط إعادة تعيين كلمة المرور بالبريد الإلكتروني
            $subject = 'إعادة تعيين كلمة المرور';
            $message = 'لإعادة تعيين كلمة المرور، انقر على الرابط التالي: http://127.0.0.1/project/login/1/reset_password_form.php?email=' . urlencode($email) . '&token=' . urlencode($reset_token);
            $headers = 'From: admin@example.com' . "\r\n" .
                       'Reply-To: admin@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            mail($email, $subject, $message, $headers);

            echo 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.';
        } else {
            echo 'حدث خطأ أثناء طلب إعادة تعيين كلمة المرور. يُرجى المحاولة مرة أخرى.';
        }
    } else {
        echo 'لا يوجد حساب مستخدم مرتبط بهذا البريد الإلكتروني.';
    }
}
?>
