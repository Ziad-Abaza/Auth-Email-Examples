<!-- forgot_password.php -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعادة تعيين كلمة المرور</title>
</head>
<body>
    <h2>نسيت كلمة المرور</h2>
    <form action="reset_password.php" method="POST">
        <label for="email">البريد الإلكتروني المسجل</label>
        <input type="email" id="email" name="email" required>
        <br>
        <input type="submit" value="استعادة كلمة المرور">
    </form>
</body>
</html>
