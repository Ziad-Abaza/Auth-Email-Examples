<!-- register_process.php -->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// تحميل الملفات المطلوبة لمكتبة PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // التحقق من وجود حساب مستخدم بنفس البريد الإلكتروني
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // البريد الإلكتروني موجود بالفعل
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
                // الخادم الذي سيتم استخدامه لإرسال البريد الإلكتروني
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '3p0oxy@gmail.com';
                $mail->Password = 'EQDOYILEXVHMCND';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet='UTF-8' ;

                // عنوان المرسل
                $mail->setFrom('3p0oxy@gmail.com', 'EgyTech-team');

                // عنوان المستلم
                $mail->addAddress($email, $username);

                // محتوى الرسالة
                $mail->isHTML(true);
                $mail->Subject = 'تفعيل الحساب';
                $mail->Body = 'لتفعيل حسابك، انقر على الرابط التالي: http://127.0.0.1/project/login/1/verify.php?email=' . urlencode($email) . '&token=' . urlencode($token);

                $mail->send();

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
