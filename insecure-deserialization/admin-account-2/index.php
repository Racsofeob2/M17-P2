<?php

include("user.php");
require("../../../lang/lang.php");
$strings = tr();
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y'])) {
    // Decode the cookie
    $cookieData = base64_decode($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y']);
    
    if ($cookieData === false || strpos($cookieData, '::') === false) {
        header("Location: login.php?msg=3");
        exit;
    }

    list($userData, $receivedHmac) = explode('::', $cookieData, 2);

    // Verify HMAC to ensure data integrity
    $calculatedHmac = hash_hmac('sha256', $userData, 'S3cr3t!');

    if (!hash_equals($calculatedHmac, $receivedHmac)) {
        header("Location: login.php?msg=3");
        exit;
    }

    try {
        $user = json_decode($userData, false, 512, JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        header("Location: login.php?msg=3");
        exit;
    }

    if (!isset($user->username) || !isset($user->isAdmin)) {
        header("Location: login.php?msg=3");
        exit;
    }

    $text = "";
    $administrator = md5('administrator');
    $admin = md5('admin');

    if ($user->isAdmin === true) {
        if (hash('md5', $user->username) === $administrator) {
            $text = $strings['welcome-real-admin'];
        } elseif (hash('md5', $user->username) === $admin) {
            $text = $strings['welcome-fake-admin'];
        } else {
            $text = $strings['welcome-fake-admin-user'];
        }
    } elseif (hash('md5', $user->username) === $administrator || hash('md5', $user->username) === $admin) {
        $text = $strings['welcome-admin-powerless'];
    } else {
        $text = $strings['welcome-test'];
    }

} else {
    header("Location: login.php?msg=2");
    exit;
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html><html lang='en' class=''>
<head>
<style>
h1{
    text-align: center;
}
</style>
<link rel='stylesheet prefetch' href='css/normalize.min.css'><script src='js/prefixfree.min.js'></script>
</head><body>

<?php echo '<h2 style="text-align: center; color:red; margin-top: 100px;">'.$text.'</h2>'; ?>

</body>
<script id="VLBar" title="<?= htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8'); ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</html>
