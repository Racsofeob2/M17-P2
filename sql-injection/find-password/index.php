<?php 
require("../../../lang/lang.php");
$strings = tr();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title> <?php echo htmlspecialchars($strings['kayit'], ENT_QUOTES, 'UTF-8'); ?> </title>
    <style>
      body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
      }
    </style>
  </head>
  <body>
    <script id="VLBar" title="<?= htmlspecialchars($strings['kayit'], ENT_QUOTES, 'UTF-8'); ?>" category-id="2" src="/public/assets/js/vlnav.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 

<?php
include('dependencies/dbConnect.php');   

if (!isset($mysqli)) {
    die("Error: No se pudo conectar a la base de datos.");
}

?>

<main>
  <div class="" style="padding: 60px;">
    <div class="container-fluid">
      <h1 class="mt-4"><?php echo htmlspecialchars($strings['kayit'], ENT_QUOTES, 'UTF-8'); ?></h1>
    
      <div class="form-group">
        <span></span>
      </div>
      <div class="row">
        <div class="col-4">
          <form method="GET">
            <input type="text" placeholder="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            <button class="btn btn-primary" type="submit"> <?php echo htmlspecialchars($strings['search'], ENT_QUOTES, 'UTF-8'); ?> </button>
          </form>
        </div>
        <div class="col-8">
          <form method="GET">
            <button class="btn btn-primary" type="submit" style="margin-left:-90px"><?php echo htmlspecialchars($strings['reset'], ENT_QUOTES, 'UTF-8'); ?></button>         
          </form>
        </div>
      </div>
      
      <div class="">
        <fieldset>
          <div class="form-group">
            <div class="">
              <div class="table-responsive mt-4">
                <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>E-Mail</th>
                      <th>Name</th>
                      <th>Surname</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = "%".$_GET['search']."%";
                        $stmt = $mysqli->prepare("SELECT id, username, email, name, surname FROM users WHERE name LIKE ?");
                        $stmt->bind_param("s", $search);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $stmt = $mysqli->prepare("SELECT id, username, email, name, surname FROM users");
                        $stmt->execute();
                        $result = $stmt->get_result();
                    }

                    while ($list = $result->fetch_assoc()) {
                        echo '
                          <tr>
                            <td>' . htmlspecialchars($list['id'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($list['username'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($list['email'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($list['name'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($list['surname'], ENT_QUOTES, 'UTF-8') . '</td>
                          </tr>';
                    }
                    $stmt->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</main>
</body>
</html>
