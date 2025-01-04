<!-- reset_password_form.php -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">      
        <div class="form-content login-form active">
            <h2>إعادة تعيين كلمة المرور</h2>
            <form action="reset_password_process.php" method="POST">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <label for="new_password">كلمة المرور الجديدة</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <label for="confirm_password">تأكيد كلمة المرور الجديدة</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <input type="submit" value="تغيير كلمة المرور">
            </form>
        </div>
    </div>
</body>
</html>
