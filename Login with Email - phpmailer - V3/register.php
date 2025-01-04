<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<h2>انشاء حساب جديد</h2>
    <form action="register_process.php" method="POST">
        <label for="username">اسم المستخدم</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="email">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">كلمة المرور</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="انشاء الحساب">
    </form>
</body>
</html>