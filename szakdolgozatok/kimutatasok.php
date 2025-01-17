<?php
require_once "database_functions.php";
session_start();

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Kimutatások</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style_picture/style.css">
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
    <main class="container-fluid container">
        <?php
        if (isadmin($_SESSION['egyetemi_azonosito'])){
            if (isset($_SESSION['egyetemi_azonosito'])){
                echo "<h2 class='text-center'>Évente dolgozatok témavezetőnként</h2>";
                eventeDolgozatokTemavezetonkent();
                '<br>';
                echo "<h2 class='text-center'>Évente dolgozatok tanszékenként</h2>";
                eventeDolgozatokTanszekenkent();
            }
        }
        ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>

