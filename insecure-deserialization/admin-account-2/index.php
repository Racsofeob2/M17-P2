<?php

include("user.php");
require("../../../lang/lang.php");
$strings = tr();
error_reporting(0);
ini_set('display_errors', 0);
if (isset($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y'])) {
    // Decode the cookie
    $cookieData = base64_decode($_COOKIE['d2VsY29tZS1hZG1pbmlzdHJhdG9y']);
    list($userData, $receivedHmac) = explode('::', $cookieData);

    // Verify HMAC to ensure data integrity
    $calculatedHmac = hash_hmac('sha256', $userData, 'S3cr3t!');

    if (hash_equals($calculatedHmac, $receivedHmac)) {
        $user = json_decode($userData);
        // Proceed with your logic
    } else {
        header("Location: login.php?msg=3");
        exit;
    }
}

    $text = "";
    $administrator = md5('administrator');
    $admin = md5('admin');
    if( $user->isAdmin == '1' ){
        if( $user->username === $administrator )
        $text = $strings['welcome-real-admin'];
        else if( $user->username === $admin )
        $text =  $strings['welcome-fake-admin'];
        else
        $text = $strings['welcome-fake-admin-user'];
    }else if( $user->username === $administrator || $user->username === $admin ){
        $text = $strings['welcome-admin-powerless'];
    }else{
        $text = $strings['welcome-test'];
    }
   

}else{
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
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</html>
