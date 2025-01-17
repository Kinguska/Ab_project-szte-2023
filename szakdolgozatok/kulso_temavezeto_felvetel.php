<?php
require_once "database_functions.php";
session_start();

$message = "";
if (isset($_POST["Új_temavezeto"])){
    $errors = [];
    if (!isset($_POST["egyetemi_azonosito"]) || trim($_POST["egyetemi_azonosito"]) === "" )  {
        $errors[] = "Add meg a témavezető egyetemi azonosítóját!";
    }
    if (!isset($_POST["nev"]) || trim($_POST["nev"]) === "" )  {
        $errors[] = "Add meg a témavezető nevét!";
    }
    if (!isset($_POST["password"]) || trim($_POST["password"]) === "" )  {
        $errors[] = "Add meg a témavezető alap jelszavát!";
    }
    if (!isset($_POST["password2"]) || trim($_POST["password2"]) === "" )  {
        $errors[] = "Add meg a témavezető alap jelszavát még egyszer!";
    }
    $_POST["elotag"] = isset($_POST["elotag"]) ? $_POST["elotag"] : "";
    $_POST["munkakori_beosztas"] = "témavezető";
    $_POST["szerepkor"] = "külső";

    if (count($errors) === 0){
        $azonosito = $_POST["egyetemi_azonosito"];
        $nev = $_POST["nev"];
        $elotag = $_POST["elotag"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $munkakor = $_POST["munkakori_beosztas"];
        $szerepkor = $_POST["szerepkor"];

        if (strlen($azonosito) > 10){
            $errors2[] = "Az egyetemi azonosító nem lehet hosszabb 10 karakternél!";
        }

        if(azonositoCheck($azonosito)){
            $errors[] = "Ez az azonosító már foglalt!";
        }
        if (strlen($password) < 6) {
            $errors[] = "A jelszó nem elég hosszú!";
        }
        if ($password2 != $password) {
            $errors[] = "A két jelszó nem egyezik meg!";
        }
        if (count($errors) === 0){
        $password = password_hash($password, PASSWORD_DEFAULT);

        szemelyInsert($azonosito, $nev, $elotag, $password, $munkakor);
        temavezetoInsert($azonosito, $szerepkor);
        $message = "Sikeres adatfelvitel!";
    }

    }

    else{
        $message = implode("<br>", $errors);
    }


}





?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Külső témavezető felvétel</title>
    <link rel="stylesheet" href="style_picture/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href=#>
            <img src="style_picture/szakdolgozat.jpg" alt="" width="50" height="40" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item text-center">
                    <?php echo $_SESSION["egyetemi_azonosito"];
                    $array = szemelyData($_SESSION["egyetemi_azonosito"]);
                    foreach ($array as $item => $value){
                        if ($value != ""){
                            echo " || ".$value . " ";
                        }
                    }
                    ?>
                </li>
            </ul>
            </div>
        <div class="container-fluid">
            <a href="Szakdolgozatok.php" class="btn btn-warning">Kezdőlap </a>
        </div>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-dark">Kijelentkezés</a>
        </div>
        </div>
</nav>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4">Szakdolgozatok</h1> <br>
            </div>
        </div>
    </div>
    <body>
    <main class="container-fluid">
        <?php
        if (isadmin($_SESSION['egyetemi_azonosito'])){
            if (isset($_SESSION['egyetemi_azonosito'])){
                ?>
                <div>
                    <form action="kulso_temavezeto_felvetel.php" method="post" id="kulso_felvetel">
                        <fieldset>
                            <label for="egyetemi_azonosito" class="form-label required-label" >Egyetemi azonosító: </label>
                            <input class="form-control" type="text" name="egyetemi_azonosito" id="egyetemi_azonosito" required
                                  maxlength="10" value="<?php if (isset($_POST["egyetemi_azonosito"])) echo $_POST["egyetemi_azonosito"] ?>"> <br>
                            <label for="nev" class="form-label required-label" >Témavezető neve: </label>
                            <input class="form-control" type="text" name="nev" id="nev" required
                                   maxlength="40" value="<?php if (isset($_POST["nev"])) echo $_POST["nev"] ?>"> <br>
                            <label for="elotag" class="form-label" >Előtag: </label>
                            <input class="form-control" type="text" name="elotag" id="elotag"
                                   maxlength="10" value="<?php if (isset($_POST["elotag"])) echo $_POST["elotag"] ?>"> <br>
                            <label for="password" class="form-label" >Alap jelszó: </label>
                            <input class="form-control" type="password" name="password" id="password"> <br>
                            <blockquote id="warning">Legalább 6 karakter hosszú jelszó szükséges!</blockquote>
                            <label for="password2" class="form-label" >Alap jelszó ismét: </label>
                            <input class="form-control" type="password" name="password2" id="password2"> <br>
                            <div class="buttons">
                                <input class="btn btn-success" type="submit" value="Új külső témavezető hozzáadása" name="Új_temavezeto">
                            </div>
                        </fieldset>
                    </form>
                </div>
                </form>
                <p>
                    <small>
                        *: Adat megadása kötelező!
                    </small>
                </p>
                </form>
                <strong class="text-uppercase">
                    <?php
                    echo $message;
                    ?>
                </strong>
                <?php
            }
        }
        ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>

