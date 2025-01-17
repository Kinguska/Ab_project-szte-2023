<?php
require_once "database_functions.php";
session_start();

$message = "";
if (isset($_POST["Új_szakdolgozat"])){
    $errors = [];
    if (!isset($_POST["dolgozat_azonosito"]) || trim($_POST["dolgozat_azonosito"]) === "" )  {
        $errors[] = "Add meg a dolgozat azonosítóját!";
    }
    if (!isset($_POST["dolgozat_cime"]) || trim($_POST["dolgozat_cime"]) === "" )  {
        $errors[] = "Add meg a dolgozat címét!";
    }
    if (!isset($_POST["tanszek"]) || trim($_POST["tanszek"]) === "" )  {
        $errors[] = "Add meg a tanszéket!";
    }
    $_POST["beadas_eve"] = isset($_POST["beadas_eve"]) ? $_POST["beadas_eve"] : NULL;
    $_POST["vedes_eve"] = isset($_POST["vedes_eve"]) ? $_POST["vedes_eve"] : NULL;
    $_POST["vedes_jegye"] = isset($_POST["vedes_jegye"]) ? $_POST["vedes_jegye"] : NULL;

    if (!isset($_POST["egyetemi_azonosito"]) || trim($_POST["egyetemi_azonosito"]) === "" )  {
        $errors[] = "Add meg a hallgató egyetemi azonosítóját!";
    }

    if (!isset($_POST["szak_azonosito"]) || trim($_POST["szak_azonosito"]) === "" )  {
        $errors[] = "Add meg a szak azonosítóját!";
    }


    if (count($errors) === 0){
        $azonosito = $_POST["dolgozat_azonosito"];
        $cim = $_POST["dolgozat_cime"];
        $tanszek = $_POST["tanszek"];
        $beadas = $_POST["beadas_eve"];
        $vedes = $_POST["vedes_eve"];
        $jegy = $_POST["vedes_jegye"];
        $egyetemi_azonosito = $_POST["egyetemi_azonosito"];
        $szak_azonosito = $_POST["szak_azonosito"];

        if (szakdolgozatCheck($azonosito)){
            $message = "Már létezik ilyen azonosítójú szakdolgozat!";
        }
        else{
            szakdolgozatokInsert($azonosito, $cim, $tanszek, $beadas, $vedes, $jegy, $egyetemi_azonosito, $szak_azonosito);
            $message = "Sikeresen hozzáadva!";
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
    <title>Szakdolgozat adatfelvitel</title>
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
                    <form action="szakdolgozatok_letrehozasa.php" method="post" id="szakdolgozatok">
                        <fieldset>
                            <label for="dolgozat_azonosito" class="form-label required-label" >Dolgozat azonosítója: </label>
                            <input class="form-control" type="text" name="dolgozat_azonosito" id="dolgozat_azonosito" required
                                   maxlength="20" value="<?php if (isset($_POST["dolgozat_azonosito"])) echo $_POST["dolgozat_azonosito"] ?>"> <br>
                            <label for="dolgozat_cime" class="form-label required-label" >Dolgozat címe: </label>
                            <input class="form-control" type="text" name="dolgozat_cime" id="dolgozat_cime" required
                                   maxlength="100" value="<?php if (isset($_POST["dolgozat_cime"])) echo $_POST["dolgozat_cime"] ?>"> <br>
                            <label for="tanszek" class="form-label required-label" >Tanszék: </label>
                            <select id="tanszek" name="tanszek" class="form-select" required>
                                <option value="" selected disabled hidden>Válassz tanszéket!</option>
                                <?php
                                    $tanszek = tanszekek();
                                    foreach ($tanszek as $item => $value){
                                        echo "<option value='$value'>$value</option>";
                                    }
                                ?>
                            </select> <br>
                            <label for="beadas_eve" class="form-label" >Beadás éve: </label>
                            <input class="form-control" type="number" min="1900" max="2500" name="beadas_eve" id="beadas_eve" > <br>
                            <label for="vedes_eve" class="form-label" >Védés éve: </label>
                            <input class="form-control" type="number" min="1900" max="2500" name="vedes_eve" id="vedes_eve" > <br>
                            <label for="vedes_jegye" class="form-label" >Védés érdemjegye: </label>
                            <input class="form-control" type="text" min="1" max="6" name="vedes_jegye" id="vedes_jegye" > <br>
                            <label for="egyetemi_azonosito" class="form-label required-label" >Hallgatói egyetemi azonosító: </label>
                            <select id="egyetemi_azonosito" name="egyetemi_azonosito" class="form-select" required>
                                <option value="" selected disabled hidden>Válassz hallgatót!</option>
                                <?php
                                $hallgato = hallgatok();
                                foreach ($hallgato as $item => $value){
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select> <br>
                            <label for="szak_azonosito" class="form-label required-label" >Szak: </label>
                            <select id="szak_azonosito" name="szak_azonosito" class="form-select" required>
                                <option value="" selected disabled hidden>Válassz szakot!</option>
                                <?php
                                $szak = szakok();
                                foreach ($szak as $item => $value){
                                    echo "<option value='$item'>$value</option>";
                                }
                                ?>
                            </select> <br>
                            <div class="buttons">
                                <input class="btn btn-warning" type="submit" value="Új szakdolgozat hozzáadása" name="Új_szakdolgozat">
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

