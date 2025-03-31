<?php

require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

$db = new DB();
$users = $db->getUsersList();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $inputUsername = md5(trim($_POST['username']));
    $inputPassword = md5(trim($_POST['password']));
    
    foreach ($users as $user) {
        if (hash_equals($user['username'], $inputUsername) && hash_equals($user['password'], $inputPassword)) {
            $userData = json_encode([
                'username' => $user['username'],
                'isAdmin' => $user['isAdmin']
            ], JSON_THROW_ON_ERROR);
            
            $hmac = hash_hmac('sha256', $userData, 'S3cr3t!');
            $cookieData = base64_encode($userData . '::' . $hmac);
            
            setcookie('d2VsY29tZS1hZG1pbmlzdHJhdG9y', $cookieData, [
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            
            header("Location: index.php");
            exit;
        }
    }
    header("Location: login.php?msg=1");
    exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <?php if (isset($_GET['msg'])): ?>
                <h2 style="color:red">
                    <?= htmlspecialchars($_GET['msg'] == 2 ? $strings['enter-system'] : $strings['invalid-credentials'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
            <?php endif; ?>
            <h1><?= htmlspecialchars($strings['sign-in'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <form method="post">
                <input type="text" name="username" placeholder="<?= htmlspecialchars($strings['username'], ENT_QUOTES, 'UTF-8'); ?>" required />
                <input type="password" name="password" placeholder="<?= htmlspecialchars($strings['password'], ENT_QUOTES, 'UTF-8'); ?>" required />
                <button type="submit" class="btn btn-primary btn-block btn-large">
                    <?= htmlspecialchars($strings['login'], ENT_QUOTES, 'UTF-8'); ?>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
