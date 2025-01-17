<?php
require_once "database_functions.php";
session_start();

$message = "";
if (isset($_POST["hallgato_kepzes"])){
    $errors = [];
    if (!isset($_POST["egyetemi_azonosito"]))  {
        $errors[] = "Add meg a hallgató azonosítóját!";
    }
    if (!isset($_POST["szak_azonosito"])) {
        $errors[] = "Add meg a szakot!";
    }

    $_POST["kezdes"] = isset($_POST["kezdes"]) ? $_POST["kezdes"] : "";
    $_POST["vegzes"] = isset($_POST["vegzes"]) ? $_POST["vegzes"] : "";
    $_POST["diploma_sorszam"] = isset($_POST["diploma_sorszam"]) ? $_POST["diploma_sorszam"] : "";

    if (count($errors) === 0) {
        $azonosito = $_POST["egyetemi_azonosito"];
        $szak_azonosito = $_POST["szak_azonosito"];
        $kezdes = $_POST["kezdes"];
        $vegzes = $_POST["vegzes"];
        $diploma_sorszam = $_POST["diploma_sorszam"];

        if (!isHallgatoSzakInKepzese($azonosito, $szak_azonosito)) {
            hallgatoKepzeseInsert($azonosito, $szak_azonosito, $kezdes, $vegzes, $diploma_sorszam);
            $message = "Sikeres felvitel!";
        }

    }
    if (count($errors) > 0){
        $message = implode("<br>", $errors);
    }

}





?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Képzés felvitel</title>
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
                    <form action="hallgato_kepzese_felvitel.php" method="post" >
                        <fieldset>
                            <label for="egyetemi_azonosito" class="form-label required-label" >Hallgató azonosítója: </label>
                            <select id="egyetemi_azonosito" name="egyetemi_azonosito" class="form-select" required>
                                <option value="" selected disabled hidden>Válassz hallgatói azonosítót!</option>
                                <?php
                                $tanszek = hallgatok();
                                foreach ($tanszek as $item => $value){
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select> <br>
                            <label for="szak_azonosito" class="form-label required-label" >Szak: </label>
                            <select class="form-select" name="szak_azonosito" id="szak_azonosito" required>
                                <option value="" selected disabled hidden>Válassz szakot!</option>
                                <?php
                                $szakok = szakok();
                                foreach ($szakok as $item => $value){
                                    echo "<option value='$item'>$value</option>";
                                }
                                ?>
                            </select> <br>
                            <label for="kezdes" class="form-label" >Kezdés szemesztere: </label>
                            <input class="form-control" type="text" name="kezdes" id="kezdes" placeholder="például 2023/24/1"
                                   pattern="[0-9]{4}/[0-9]{2}/[0-2]"> <br>
                            <label for="vegzes" class="form-label" >Végzés szemesztere: </label>
                            <input class="form-control" type="text" name="vegzes" id="vegzes" placeholder="például 2023/24/2"
                                   pattern="[0-9]{4}/[0-9]{2}/[0-2]"> <br>
                            <label for="diploma_sorszam" class="form-label" >Diploma sorszáma: </label>
                            <input class="form-control" type="text" name="diploma_sorszam" id="diploma_sorszam"> <br>
                            <div class="buttons">
                                <input class="btn btn-warning" type="submit" value="Hallgató képzésének felvitele" name="hallgato_kepzes">
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

