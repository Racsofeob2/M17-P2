<?php
    require("../../../lang/lang.php");
    $strings = tr();
    
    if( isset($_POST['submit']) ){

        $tmpName = $_FILES['input_image']['tmp_name'];
        $fileName = $_FILES['input_image']['name'];
        
        if(!empty($fileName)){

            // Obtener extensión del archivo en minúsculas
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Extensiones permitidas
            $allowedExtensions = array("gif", "jpg", "jpeg", "png");
    
            if(!file_exists("uploads")){
                mkdir("uploads", 0755, true);
            }
    
            $uploadPath = "uploads/".basename($fileName);
    
            // Verificar si la extensión está permitida
            if( in_array($fileExt, $allowedExtensions) ){
    
                if( move_uploaded_file($tmpName, $uploadPath) ){
                    $status = "success";
                }else{
                    $status = "unsuccess";
                    error_log("Error al subir archivo: ".$_FILES['input_image']['error']);
                }
    
            }else{
                $status = "blocked";
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
                            <?= $strings['card_formats']; ?> 
                            <b>gif, jpg, jpeg, png</b>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <?php
                        if( isset($status) ){
                            if( $status == "success" ){
                                echo '<div class="alert alert-success" role="alert">
                                <b>'.$strings['alert_success'].'</b> 
                                <hr>'
                                .$strings['alert_success_file_path'].'<a class="text-success" href="'.$uploadPath.'"> <b>'.$uploadPath.'</b> </a> 
                                </div>';
                            }
                            if( $status == "unsuccess" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_unsuccess'].'</b> 
                                <hr>Error: '.$_FILES['input_image']['error'].'
                                </div>';
                            }
                            if( $status == "blocked" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_blocked'].'</b> <hr>'
                                .$strings['alert_blocked_type'].': <b>'.$fileExt.'</b><br>
                                '.$strings['card_formats'].': <b>gif, jpg, jpeg, png</b>
                                </div>';
                            }
                            if( $status == "empty" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_empty'].'</b> 
                                </div>';
                            }
                        }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="input_image" class="form-label"><?= $strings['input_label']; ?></label>
                            <input class="form-control" type="file" id="input_image" name="input_image" accept=".gif,.jpg,.jpeg,.png"> 
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
