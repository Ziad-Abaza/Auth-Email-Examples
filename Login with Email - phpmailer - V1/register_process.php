<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// تحميل الملفات المطلوبة لمكتبة PHPMailer
require 'vendor/autoload.php';
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // اسم المستخدم المُدخل في النموذج
    $email = $_POST['email']; // البريد الإلكتروني المُدخل في النموذج
    $password = $_POST['password']; // كلمة المرور المُدخلة في النموذج

    // التحقق من وجود حساب مستخدم بنفس البريد الإلكتروني في قاعدة البيانات
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // البريد الإلكتروني موجود بالفعل في قاعدة البيانات
        echo 'هذا البريد الإلكتروني مستخدم بالفعل. يُرجى استخدام بريد إلكتروني آخر.';
    } else {
        // إنشاء حساب جديد
        $token = bin2hex(random_bytes(32)); // إنشاء رمز عشوائي للتأكيد
        $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // صلاحية الرمز لمدة ساعة

        // حفظ معلومات المستخدم الجديد في قاعدة البيانات
        $sql_insert_user = "INSERT INTO users (username, email, password, token, token_expiration) VALUES ('$username', '$email', '$password', '$token', '$token_expiration')";
        if (mysqli_query($conn, $sql_insert_user)) {
            // إرسال رسالة بريد إلكتروني للتحقق
            $mail = new PHPMailer(true);

            try {
                // إعدادات الخادم لإرسال البريد الإلكتروني
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'IT.club.BATU@gmail.com'; // البريد الإلكتروني للحساب المُرسِل
                $mail->Password = 'acthvgcxuwuduxbp'; // كلمة المرور للبريد الإلكتروني المُرسِل
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->CharSet = 'UTF-8';

                // المُرسِل والمُستلِم للبريد الإلكتروني
                $mail->setFrom('IT.club.BATU@gmail.com', 'اسم المُرسِل');
                $mail->addAddress($email, $username); // إضافة مُستلِم للبريد الإلكتروني

                // محتوى البريد الإلكتروني
                $mail->isHTML(true); // تحديد تنسيق HTML للبريد
                $mail->Subject = 'تفعيل الحساب';
                $mail->Body = 'لتفعيل حسابك، انقر على الرابط التالي: http://127.0.0.1/project/login/1/verify.php?email=' . urlencode($email) . '&token=' . urlencode($token);

                $mail->send(); // إرسال البريد الإلكتروني

                echo 'تم إنشاء الحساب بنجاح. يُرجى التحقق من البريد الإلكتروني لتفعيل الحساب.';
            } catch (Exception $e) {
                echo 'حدث خطأ أثناء إرسال البريد الإلكتروني: ' . $mail->ErrorInfo;
            }
        } else {
            echo 'حدث خطأ أثناء إنشاء الحساب. يُرجى المحاولة مرة أخرى.';
        }
    }
}
?>
