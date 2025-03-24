<?php

require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

$db = new DB();
$users = $db->getUsersList();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
    
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    foreach ($users as $user) {
        if (hash_equals($user['username'], hash('md5', $inputUsername)) && 
            hash_equals($user['password'], hash('md5', $inputPassword))) {

            // Crear array con los datos del usuario
            $userData = json_encode([
                'username' => $user['username'],
                'isAdmin'  => $user['isAdmin']
            ], JSON_THROW_ON_ERROR);

            // Generar HMAC para integridad
            $hmac = hash_hmac('sha256', $userData, 'S3cr3t!');
            $cookieData = base64_encode($userData . '::' . $hmac);

            // Configurar cookie segura con HTTPOnly y Secure
            setcookie(
                'd2VsY29tZS1hZG1pbmlzdHJhdG9y',
                $cookieData,
                [
                    'expires' => time() + 3600, // 1 hora
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );

            header("Location: index.php");
            exit;
        }
    }

    header("Location: login.php?msg=1");
    exit;
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet prefetch" href="css/normalize.min.css">
    <script src="js/prefixfree.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="login">
            <?php 
            if (isset($_GET['msg'])) {            
                if ($_GET['msg'] == 2) {
                    echo "<h2 style='color:red'>" . htmlspecialchars($strings['enter-system'], ENT_QUOTES, 'UTF-8') . "</h2>";
                } else {
                    echo "<h2 style='color:red'>" . htmlspecialchars($strings['invalid-credentials'], ENT_QUOTES, 'UTF-8') . "</h2>";
                }
            }
            ?>
            <h1><?= htmlspecialchars($strings['sign-in'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <form method="post">
                <input type="text" name="username" placeholder="<?= htmlspecialchars($strings['username'], ENT_QUOTES, 'UTF-8'); ?>" required />
                <input type="password" name="password" placeholder="<?= htmlspecialchars($strings['password'], ENT_QUOTES, 'UTF-8'); ?>" required />
                <button type="submit" class="btn btn-primary btn-block btn-large"><?= htmlspecialchars($strings['login'], ENT_QUOTES, 'UTF-8'); ?></button>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8'); ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
