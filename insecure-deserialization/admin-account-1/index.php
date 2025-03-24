<?php
// login.php modificado
session_start();
$strings = [
    'login_error' => 'Invalid username or password.',
    'username' => 'Username',
    'password' => 'Password',
    'login' => 'Login'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"> <?php echo $strings['login_error']; ?> </p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="process_login.php" method="POST">
        <label for="username"> <?php echo $strings['username']; ?> </label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password"> <?php echo $strings['password']; ?> </label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit"> <?php echo $strings['login']; ?> </button>
    </form>
</body>
</html>
