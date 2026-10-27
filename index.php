<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <h2>Form Login</h2>

    <form action="proses/auth.php" method="POST">
        <input type="hidden" name="action" value="login">

        <label>Email</label><br>
        <input type="text" name="email" required>

        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p>
        Belum punya akun?
        <a href="register.php">Register</a>
    </p>

</body>
</html>