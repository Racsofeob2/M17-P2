<?php

$db = new PDO('sqlite:users.db');
$html= "";

if(isset($_POST['username']) && isset($_POST['password'])  ){
    $q = $db->prepare("SELECT * FROM users_ WHERE username=:user");
    $q->execute(array('user' => $_POST['username']));
    $_select = $q->fetch();

    if ($_select && password_verify($_POST['password'], $_select['password'])) {
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $html = $strings["cong"];
    } else {
        $html = $strings["wrong"];
    }

}

?>
