<?php
require("../../../lang/lang.php");
$strings = tr();
require("brute.php");

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= htmlspecialchars($strings["title"], ENT_QUOTES, 'UTF-8'); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= htmlspecialchars($strings["login"], ENT_QUOTES, 'UTF-8'); ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= htmlspecialchars($strings["username"], ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= htmlspecialchars($strings["password"], ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= htmlspecialchars($strings["submit"], ENT_QUOTES, 'UTF-8'); ?></button>
                <p class="mt-3"><?= htmlspecialchars($strings["hint"], ENT_QUOTES, 'UTF-8'); ?></p>

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <?php
                echo '<h1>' . htmlspecialchars($html, ENT_QUOTES, 'UTF-8') . '</h1>';
                ?>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings["title"], ENT_QUOTES, 'UTF-8'); ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
