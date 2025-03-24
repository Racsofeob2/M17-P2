<?php

// Connectar a la base de dades
$db = new PDO('sqlite:users.db');
$html = "";

// Comprovació de CSRF
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Crear un token CSRF
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    
    // Validar les dades d'entrada
    $username = trim($_POST['username']); // Eliminar espais al principi i final
    $password = trim($_POST['password']);

    // Verificar que els valors no estiguin buits
    if (empty($username) || empty($password)) {
        $html = "Tots els camps són obligatoris!";
    } else {
        // Preparar la consulta per prevenir SQL Injection
        $q = $db->prepare("SELECT * FROM users_ WHERE username=:user");
        $q->execute(array('user' => $username));
        $_select = $q->fetch();

        // Comprovar les credencials
        if ($_select && password_verify($password, $_select['password'])) {
            $_SESSION['username'] = $username;
            $html = "Benvingut, " . htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        } else {
            $html = "Usuari o contrasenya incorrectes.";
        }
    }
} else {
    $html = "Sol·licitud no vàlida.";
}

?>
