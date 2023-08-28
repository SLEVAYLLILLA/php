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

        if ($lenght < 2 || $lenght > 30) {
          $errors[] = 'A név minimum 2 maximum 30 karakter lehet!';
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
          $errors[] = 'Az email cím invalid formátumú!';
        }

        $lenght = strlen($_POST["password"]);

        if ($lenght < 4 || $lenght > 20) {
          $errors[] = 'A jelszó minimum 4 maximum 20 karakter lehet!';
        }

        if ($_POST["password"] != $_POST["password_confirmation"]) {
          $errors[] = 'A két jelszó nem azonos!';
        }

        $lenght = strlen($_POST["street"]);

        if ($lenght < 2 || $lenght > 30) {
          $errors[] = 'Az utca minimum 2 maximum 30 karakter lehet!';
        }

        $lenght = strlen($_POST["nr"]);

        if ($lenght < 1 || $lenght > 30) {
          $errors[] = 'A házszám kötelező, és maximum 30 karakter lehet!';
        }

        $lenght = strlen($_POST["city"]);

        if ($lenght < 2 || $lenght > 30) {
          $errors[] = 'A város minimum 2 maximum 30 karakter lehet!';
        }

        $lenght = strlen($_POST["zip"]);

        if ($lenght != 4) {
          $errors[] = 'Az irányítószám 4 karakter lehet!';
        }

        if (count($errors) > 0) {
          print '<div class="alert alert-danger" role="alert">';
          foreach ($errors as $error) {
            print "$error <br>";
          }
          print '</div>';
        } else {

          $nevek = $_POST["name"];
          if (strpos($nevek, " ") !== false) {
            $first_name = explode(" ", $nevek)[0];
            $last_name = explode(" ", $nevek)[1];
          } else {
            $first_name = "";
            $last_name = $nevek;
          }
          mysqli_query($connection, "insert into users
(first_name, last_name, email, password, street, nr, city, zip)
values
('" .$first_name. "', '".$last_name."',  '" . $_POST["email"] . "','" . $_POST["password"] . "','" . $_POST["street"] . "','" . $_POST["nr"] . "','" . $_POST["city"] . "','" . $_POST["zip"] . "')");

          print '<div class="alert alert-success" role="alert">
Sikeres regisztráció
</div>';
        }
      }
      ?>
      <h2 class="col-12 text-center">Regisztráció</h2>
      <div class="col-md-8 col-lg-6 mx-auto">
        <form class="row g-3" method="post">

          <div class="col-md-6">
            <label for="name" class="form-label">Név</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="col-md-6">
            <label for="password _confirmation" class="form-label">Jelszó ismét</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
          </div>
          <div class="col-6">
            <label for="street" class="form-label">Utca</label>
            <input type="text" class="form-control" id="street" placeholder="" name="street">
          </div>
          <div class="col-6">
            <label for="nr" class="form-label">Házszám</label>
            <input type="text" class="form-control" id="nr" placeholder="" name="nr">
          </div>
          <div class="col-md-8">
            <label for="city" class="form-label">Város</label>
            <input type="text" class="form-control" id="city" name="city">
          </div>
          <div class="col-md-4">
            <label for="zip" class="form-label">Irányítószám</label>
            <input type="text" class="form-control" id="zip" name="zip">
          </div>
          <div class="col-12 text-center pt-3">
            <button type="submit" name="submitted" class="btn btn-success">Regisztráció</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>