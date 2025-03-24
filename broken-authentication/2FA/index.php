<?php
require("../../../lang/lang.php");
$strings = tr();
session_start(); // Iniciar sesión antes de manipularla
session_unset(); // Resetear datos de sesión

// Definir credenciales almacenadas
$storedUsername = 'admin';
$storedPasswordHash = '$2y$10$QGeqwpY6Z1KhDeM9Bd8I8.ezKzk6noCewgS2A/h3Pn1zxVve9gFCi'; // Hash de 'admin'

// Manejo de intentos fallidos
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($_SESSION['login_attempts'] >= 5) {
        $errorMessage = 'Demasiados intentos fallidos. Intente más tarde.';
    } else {
        if ($username === $storedUsername && password_verify($password, $storedPasswordHash)) {
            $_SESSION['login_attempts'] = 0; // Resetear intentos

            $randomCode = random_int(10000, 99999); // Uso seguro de generación aleatoria
            $_SESSION['2fa_code'] = $randomCode;
            $_SESSION['username'] = $username;

            header('Location: 2fa.php');
            exit();
        } else {
            $_SESSION['login_attempts']++;
            $errorMessage = 'Credenciales incorrectas. Inténtalo de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($strings["login"], ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="padding-top:5%;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-auto">
                    <div class="card-header bg-primary text-white text-center">
                        <h2><?= htmlspecialchars($strings["login"], ENT_QUOTES, 'UTF-8'); ?></h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($errorMessage)) : ?>
                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php endif; ?>
                        <form action="index.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label"><?= htmlspecialchars($strings["ka"], ENT_QUOTES, 'UTF-8'); ?></label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><?= htmlspecialchars($strings["pass"], ENT_QUOTES, 'UTF-8'); ?></label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <p class="text-center"><?= htmlspecialchars($strings["not"], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= htmlspecialchars($strings["submit"], ENT_QUOTES, 'UTF-8'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

