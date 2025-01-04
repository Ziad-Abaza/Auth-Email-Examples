<!-- forgot_password.php -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعادة تعيين كلمة المرور</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container"> 
        <div class="form-content login-form active">
        <h2>نسيت كلمة المرور</h2>
        <form action="reset_password.php" method="POST">
        <label for="email">البريد الإلكتروني المسجل</label>
        <input type="email" id="email" name="email" placeholder="email" required>
        <br>
        <button required name="" autofocus >استعادة كلمة المرور</button>
            </form>
        </div>
    </div>
</body>
</html>
