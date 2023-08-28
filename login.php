<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account kezelés példa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Account kezelés</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <?php if(isset($_SESSION["user"])==false){?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Regisztráció</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Belépés</a>
          </li>

          <?php }else{ ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profilom</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link ">Kilépés</a>
          </li>

<?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container pt-5" action="" method="post">
    <div class="row g-3">

      <?php if (isset($_POST["submitted"])) {

        $connection = mysqli_connect("localhost:3306", "root", "19890808", "gyakorlas2");
        mysqli_set_charset($connection, "utf8mb4");
        $lenght = strlen($_POST["name"]);
        $errors = [];

        if(empty($_POST["email"])){
          $errors[]='Az email cím kötelező';
        }
      
        if(empty($_POST["password"])){
          $errors[]='A jelszó kötelező';
        }

          if(count($errors)>0){
            print '<div class="alert alert-danger col-md-6 col-lg-4 mx-auto" role="alert">';
          foreach ($errors as $error){
            print "$error <br>";
          }
          print '</div>';
          }
          else{

              $sql=mysqli_query($connection, "select * from users where email='".$_POST["email"]."' ");
              $user=mysqli_fetch_array($sql);

              if(isset($user["email"])==false){
                $errors[]='Nincs találat!';
              } else{
                if($user["password"]!=$_POST["password"]){
                  $errors[]='Hibás jelszó!';
                }
              
              }
              if(count($errors)>0){
                print '<div class="alert alert-danger col-md-6 col-lg-4 mx-auto" role="alert">';
              foreach ($errors as $error){
                print "$error <br>";
              }
              print '</div>';
            }
            else{
             $_SESSION["user"]= $user;
             header("location: profile.php");
            }

          }
      }
      ?>
      <h2 class="col-12 text-center">Belépés</h2>
      <div class="col-md-6 col-lg-4 mx-auto">
        <form class="row g-3" method="post">

          
          <div class="col-md-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="col-md-12">
            <label for="password" class="form-label">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="col-12 text-center pt-3">
            <button type="submit" name="submitted" class="btn btn-success">Belépés</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>