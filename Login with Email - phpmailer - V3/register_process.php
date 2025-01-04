<!-- register_process.php -->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// تحميل مكتبة PHPMailer لإرسال البريد الإلكتروني
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// تحميل ملف التكوين لقاعدة البيانات
include 'db_config.php';

// التحقق من أن الطلب هو نوع POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // جلب المتغيرات من النموذج المرسل
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // إنشاء رمز عشوائي للتأكيد
    $token = bin2hex(random_bytes(32));
    // صلاحية الرمز لمدة ساعة
    $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // حفظ معلومات المستخدم الجديد والرمز العشوائي في قاعدة البيانات وتعيين الحساب غير مفعّل
    $sql_insert_user = "INSERT INTO users (username, email, password, token, token_expiration, is_active) VALUES ('$username', '$email', '$password', '$token', '$token_expiration', 0)";
    if (mysqli_query($conn, $sql_insert_user)) {
        // إرسال رسالة بريد إلكتروني للتحقق
        $mail = new PHPMailer(true);

        try {
            // إعدادات البريد الإلكتروني الصادر
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'IT.club.BATU@gmail.com'; // بريد المرسل هنا
            $mail->Password = 'acthvgcxuwuduxbp'; // كلمة مرور بريد المرسل هنا
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // عنوان المرسل
            $mail->setFrom('IT.club.BATU@gmail.com', 'EgyTech-team');

            // عنوان المستلم
            $mail->addAddress($email, $username);

            // محتوى الرسالة
            $mail->isHTML(true);
            $mail->Subject = 'active your account';
            $mail->Body = 'لتفعيل حسابك، انقر على الرابط التالي: http://127.0.0.1/project/login/3/verify.php?email=' . urlencode($email) . '&token=' . urlencode($token);

            $mail->send();

            echo 'تم إنشاء الحساب بنجاح. يُرجى التحقق من البريد الإلكتروني لتفعيل الحساب.';
        } catch (Exception $e) {
            // حدث خطأ أثناء إرسال البريد الإلكتروني
            echo 'حدث خطأ أثناء إرسال البريد الإلكتروني: ' . $mail->ErrorInfo;
        }
    } else {
        // حدث خطأ أثناء إنشاء الحساب في قاعدة البيانات
        echo 'حدث خطأ أثناء إنشاء الحساب. يُرجى المحاولة مرة أخرى.';
    }
}
?>
