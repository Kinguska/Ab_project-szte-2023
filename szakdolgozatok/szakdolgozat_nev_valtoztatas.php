<?php
require_once "database_functions.php";
session_start();


$azonosito = $_GET["azonosito"];

$message = "";
if (isset($_POST["Új_szakdolgozat_nev"])){
    $errors = [];
    if (!isset($_POST["dolgozat_uj_cime"]) || trim($_POST["dolgozat_uj_cime"]) === "" )  {
        $errors[] = "Add meg a dolgozat új címét!";
    }
    $azonosito = $_POST["azonosito"];
    if (count($errors) === 0){
        $cim = $_POST["dolgozat_uj_cime"];
        szakdolgozatCimModify($azonosito, $cim);
        $message = "Sikeres adatmódosítás!";
        header("Location: Szakdolgozatok.php");

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
    <title>Szakdolgozat név változtatás</title>
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
        if (istemavezeto($_SESSION['egyetemi_azonosito'])){
            if (isset($_SESSION['egyetemi_azonosito'])){
                ?>
                <div>
                    <form action="szakdolgozat_nev_valtoztatas.php" method="post" id="szakdolgozat_nev">
                        <fieldset>
                            <label for="azonosito" class="form-label" >Azonosító: </label>
                            <input class="form-control" type="text" name="azonosito" id="azonosito" value="<?php echo $azonosito ?>" readonly> <br>
                            <label for="dolgozat_uj_cime" class="form-label required-label" >Dolgozat új címe: </label>
                            <input class="form-control" type="text" name="dolgozat_uj_cime" id="dolgozat_uj_cime" required> <br>
                            <div class="buttons">
                                <input class="btn btn-success" type="submit" value="Szakdolgozat címének megváltoztatása" name="Új_szakdolgozat_nev">
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


