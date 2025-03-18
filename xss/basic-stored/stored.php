<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8'); ?></title>
</head>

<body>
    <div class="alert alert-primary d-flex justify-content-center" style="text-align: center;width: fit-content;margin: auto;margin-top: 3vh;">
        <h6><?php echo htmlspecialchars($strings['text'], ENT_QUOTES, 'UTF-8'); ?></h6>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="wrapper col-md-6  shadow-lg" style="border-radius: 15px; margin-top: 4vh;">
            <div class="shadow-sm m-2 scrollspy-example chat-log d-flex flex-column justify-content-end align-items-end overflow-auto" style="min-height: 350px;border: rgb(206, 206, 206) 1px solid; border-radius: 15px;" data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" tabindex="0">
                <?php
                session_start();
                if (!isset($_SESSION['username'])) {
                    header("Location: index.php");
                    exit;
                }
                $uname = $_SESSION['username'];

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $q = $db->query("SELECT * FROM mandalorian_content");

                if ($q) {
                    while ($cikti = $q->fetch(PDO::FETCH_ASSOC)) {
                        // Escape the content before outputting to prevent XSS
                        echo '<div class="msg col-md-6 m-3 px-4 bg-primary text-wrap " style="border-radius: 20px; padding: 5px;width: fit-content;color: aliceblue;">';
                        echo htmlspecialchars($cikti['content'], ENT_QUOTES, 'UTF-8');
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="p-3 pb-0" style="text-align: center;">
                <form action="#" method="POST" style="margin: 0;">
                    <!-- Escape the placeholder text -->
                    <textarea placeholder="<?php echo htmlspecialchars($strings['message'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" rows="3" name="mes"></textarea>
                    <button type="submit" class="btn btn-primary m-3"><?php echo htmlspecialchars($strings['submit'], ENT_QUOTES, 'UTF-8'); ?></button>
                </form>
            </div>
        </div>
    </div>
    <form action="#" method="post">
        <button type="submit" name="del" class="btn btn-primary m-3"><?php echo htmlspecialchars($strings['delete'], ENT_QUOTES, 'UTF-8'); ?></button>
    </form>

    <?php

    if (isset($_POST['del'])) {
        $q = $db->prepare("DELETE FROM `mandalorian_content`");
        $q->execute();

        header("Location: stored.php");
        exit;
    }

    // Sanitize and insert the user message safely
    if (isset($_POST['mes'])) {
        $message = htmlspecialchars($_POST['mes'], ENT_QUOTES, 'UTF-8'); // Escape user input
        $q = $db->prepare("INSERT INTO mandalorian_content (username,content) VALUES (:username,:message)");
        $q->execute(array(
            "username" => $_SESSION['username'],
            "message" => $message, // Insert the sanitized message
        ));
        header("Location: stored.php");
        exit;
    }

    ?>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8') ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
