<?php
require("../../../lang/lang.php");
$strings = tr();

// DB connection
$db = new PDO('sqlite:database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch image path from DB
$img_pth = $db->prepare("SELECT * FROM images WHERE username=:user");
$img_pth->execute(array('user' => "mandalorian"));
$path = $img_pth->fetch(PDO::FETCH_ASSOC);

// Handle image upload
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a valid image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file extension
    if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Proceed with the upload if valid
    if($uploadOk == 1) {
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Update the database with the new image path
            $pth_update = $db->prepare("UPDATE images SET path=:pth WHERE username=:user");
            $pth_update->execute(array(
                'pth' => urldecode($target_file),
                'user' => "mandalorian",
            ));
            header("Location: index.php");
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5 mt-5 mb-3 d-flex justify-content-center">
                <div class="row col-md-4 text-center d-flex justify-content-center shadow-lg p-3 mb-5 rounded">
                    <!-- Display image -->
                    <img src="<?php echo htmlspecialchars($path['path'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 300px;margin-top: 8px;" class="rounded-circle" alt="Profile Image">
                    
                    <!-- Image upload form -->
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div>
                            <label for="input_image" class="form-label mt-1"><?php echo htmlspecialchars($strings['text'], ENT_QUOTES, 'UTF-8'); ?></label>
                            <input class="form-control" type="file" id="image" name="image">
                            <input class="btn btn-primary mt-2" type="submit" value="<?= htmlspecialchars($strings['button'], ENT_QUOTES, 'UTF-8'); ?>" name="submit">
                        </div>
                    </form>
                    
                    <!-- User Info Table -->
                    <table class="mt-4 table table-striped table-hover" style="border-radius: 10px;">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3><?php
                                        $q = $db->prepare("SELECT * FROM users WHERE username=:user");
                                        $q->execute(array('user' => "mandalorian"));
                                        $result = $q->fetch(PDO::FETCH_ASSOC);
                                        echo htmlspecialchars($strings['welcome'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($result["username"], ENT_QUOTES, 'UTF-8');
                                    ?></h3>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($strings['name'], ENT_QUOTES, 'UTF-8'); ?>:</td>
                                <td style="border-left: 1px black solid;"><?php echo htmlspecialchars($result["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo htmlspecialchars($strings['surname'], ENT_QUOTES, 'UTF-8'); ?>:</td>
                                <td style="border-left: 1px black solid;"><?php echo htmlspecialchars($result["surname"], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo htmlspecialchars($strings['age'], ENT_QUOTES, 'UTF-8'); ?>:</td>
                                <td style="border-left: 1px black solid;"><?php echo htmlspecialchars($result["age"], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo htmlspecialchars($strings['profession'], ENT_QUOTES, 'UTF-8'); ?>:</td>
                                <td style="border-left: 1px black solid;"><?php echo htmlspecialchars($result["prof"], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script id="VLBar" title="<?= htmlspecialchars($strings['title'], ENT_QUOTES, 'UTF-8'); ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
