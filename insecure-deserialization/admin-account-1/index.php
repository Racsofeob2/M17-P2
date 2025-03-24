<?php
 
include("user.php");
error_reporting(0);
ini_set('display_errors', 0);

if( isset($_COOKIE['V2VsY29tZS1hZG1pbgo']) ){
    try{
        define("SECRET_KEY", "S3cr3t!"); 
        $cookieData = base64_decode($_COOKIE['V2VsY29tZS1hZG1pbgo']);
        list($userData, $hmac) = explode('::', $cookieData, 2);

        if (hash_hmac('sha256', $userData, SECRET_KEY) !== $hmac) {
            throw new Exception("Invalid cookie signature");
        }

        $user = json_decode($userData, true);
        if (!$user || !isset($user['username'])) {
            throw new Exception("Invalid cookie data");
        }
    }catch(Exception $e){
        header("Location: login.php?msg=3");
        exit;
    } 
    $text = "";
    if( $user['username'] === "admin"){
        $text = "Welcome, Admin!";
    } else if ( $user['username'] === "test"){
        $text = "Welcome, Test User!";
    }else{
        $text =  "Welcome, User!";
    }

}else{
    header("Location: login.php?msg=2");
    exit;
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
<style>
h1{
    text-align: center;
 }
</style>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

<?php echo '<h2 style="text-align: center; color:red; margin-top: 100px;">'.$text.'</h2>'; ?>

</body>
</html>
