<?php

include("user.php");
require("../../../lang/lang.php");
$strings = tr();
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y'])) {
    $cookieData = base64_decode($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y']);
    $parts = explode('::', $cookieData);
    
    if (count($parts) === 2) {
        list($userData, $receivedHmac) = $parts;
        $calculatedHmac = hash_hmac('sha256', $userData, 'S3cr3t!');
        
        if (hash_equals($calculatedHmac, $receivedHmac)) {
            $user = json_decode($userData, false, 512, JSON_THROW_ON_ERROR);
        } else {
            setcookie('d2VsY29tZS1hZG1pbmlzdHJhdG9y', '', time() - 3600, "/");
            header("Location: login.php?msg=3");
            exit;
        }
    } else {
        header("Location: login.php?msg=3");
        exit;
    }
} else {
    header("Location: login.php?msg=2");
    exit;
}

$text = "";
$administrator = md5('administrator');
$admin = md5('admin');

if (!empty($user) && isset($user->isAdmin) && isset($user->username)) {
    if ($user->isAdmin == '1') {
        if ($user->username === $administrator) {
            $text = $strings['welcome-real-admin'];
        } elseif ($user->username === $admin) {
            $text = $strings['welcome-fake-admin'];
        } else {
            $text = $strings['welcome-fake-admin-user'];
        }
    } elseif ($user->username === $administrator || $user->username === $admin) {
        $text = $strings['welcome-admin-powerless'];
    } else {
        $text = $strings['welcome-test'];
    }
} else {
    header("Location: login.php?msg=2");
    exit;
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <style>
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center; color:red; margin-top: 100px;">
        <?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?>
    </h2>
</body>
</html>
