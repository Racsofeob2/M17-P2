<?php
    require("../../../lang/lang.php");
    $strings = tr();

    if( isset($_POST['submit']) ){
        
        $tmpName = $_FILES['input_image']['tmp_name'];
        $fileName = $_FILES['input_image']['name'];
        $fileType = $_FILES['input_image']['type']; // Obtenim el tipus MIME de l'arxiu
        
        // Array de tipus d'arxius permesos
        $allowedTypes = array("image/gif", "image/png", "image/jpg", "image/jpeg");

        if(!empty($fileName)){
            if(in_array($fileType, $allowedTypes)) { // Verifiquem si el tipus és permès
                if(!file_exists("uploads")){
                    mkdir("uploads");
                }
        
                $uploadPath = "uploads/".$fileName;
        
                if( @move_uploaded_file($tmpName,$uploadPath) ){
                    $status = "success";
                }else{
                    $status = "unsuccess";
                }
            } else {
                $status = "invalid_type"; // Estat per a arxius de tipus no permès
            }
        }else{
            $status = "empty";
        }
    }
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['title']; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    
    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h1><?= $strings['title']; ?></h1>
                    <a href="delete.php"><button type="button" class="btn btn-secondary btn-sm"><?= $strings['delete_button']; ?></button></a>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row pt-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                        <?= $strings['card_formats']; ?> <b><?= $strings['card_formats_type']; ?> </b>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <?php
                        if( isset($status) ){
                            if( $status == "success" ){
                                echo '<div class="alert alert-success" role="alert">
                                <b>'.$strings['alert_success'].'</b> 
                                <hr>'.$strings['alert_success_file_path'].'<a class="text-success" href="'.$uploadPath.'"> <b>'.$uploadPath.'</b> </a> 
                                </div>';
                            }
                            if( $status == "unsuccess" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_unsuccess'].'</b> 
                                </div>';
                            }
                            if( $status == "empty" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_empty'].'</b> 
                                </div>';
                            }
                            if( $status == "invalid_type" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_invalid_type'].'</b> 
                                </div>';
                            }
                        }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="input_image" class="form-label"><?= $strings['input_label']; ?></label>
                            <input class="form-control" type="file" id="input_image" name="input_image"> 
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="7" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
