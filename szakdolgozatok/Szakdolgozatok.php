<?php
require_once "database_functions.php";
session_start();

if(isset($_POST["Új"])){
    header("Location: szakdolgozatok_letrehozasa.php");
}

if (isset($_POST["Kulso"])){
    header("Location: temavezeto_felvetele.php");
}

if (isset($_POST["Szk_torles"])){
    header("Location: delete_szakdolgozat.php");
}

if (isset($_POST["h_delete"])){
    header("Location: delete_hallgato.php");
}

if (isset($_POST["h_kepzes"])){
    header("Location: hallgato_kepzese_felvitel.php");
}

if (isset($_POST["kimutatas"])){
    header("Location: kimutatasok.php");
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Szakdolgozatok</title>
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
        <div class="container-fluid">
            <a href="delete_szemely.php" class="btn btn-danger">Felhasználó törlése </a>
        </div>
        <div class=d-flex>
        <a href="logout.php" class="btn btn-dark">Kijelentkezés</a>
        </div>
        </div>
</nav>

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <br>
                <h1 class="display-4 fw-semibold">Szakdolgozatok</h1>
                <?php if (isadmin($_SESSION['egyetemi_azonosito'])){ ?>
                <h3 class="display-9">Adminisztrátori beavatkozások</h3> <br>
                <?php } ?>
                <?php if (ishallgato($_SESSION['egyetemi_azonosito'])){ ?>
                    <h3 class="display-9">Hallgatói nézelődések</h3> <br>
                <?php } ?>
                <?php if (istemavezeto($_SESSION['egyetemi_azonosito'])){ ?>
                    <h3 class="display-9">Témavezetői tevékenységek</h3> <br>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
<body>
<main class="container-fluid container">

    <?php
    if (ishallgato($_SESSION['egyetemi_azonosito'])){
        if (isset($_SESSION['egyetemi_azonosito'])){
            szakdolgozatokKiir($_SESSION['egyetemi_azonosito']);
        }
    }
    if (istemavezeto($_SESSION['egyetemi_azonosito'])){
        if (isset($_SESSION['egyetemi_azonosito'])){
            echo "<h2 class='text-center'>Szakdolgozataid témavezetőként</h2>";
            szakdolgozatokTemavezetoKiir($_SESSION['egyetemi_azonosito']);
            '<br>';
            echo "<h2 class='text-center'>Sikeres védések</h2>";
            eventeSikeresVedesek($_SESSION['egyetemi_azonosito']);
        }
    }

    if (isadmin($_SESSION['egyetemi_azonosito'])){
        if (isset($_SESSION['egyetemi_azonosito'])){
        ?>
            <form action="szakdolgozatok_letrehozasa.php" method="POST" id="letrehozas">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-warning" type="submit" value="Új szakdolgozat hozzáadása" name="Új">
                    </div>
                </fieldset>
            </form>
            <form action="kulso_temavezeto_felvetel.php" method="POST" id="kulso">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-success" type="submit" value="Külső témavezető felvétele a rendszerbe" name="Kulso">
                    </div>
                </fieldset>
            </form>
            <form action="delete_szakdolgozat.php" method="POST" id="delete_szk_">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-danger" type="submit" value="Szakdolgozat törlése" name="Szk_torles">
                    </div>
                </fieldset>
            </form>
            <form action="temavezeto_hozzarendeles.php" method="POST" id="hozzarendel">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-warning" type="submit" value="Témavezető szakdolgozathoz rendelése" name="tmv_hozzarendel">
                    </div>
                </fieldset>
            </form>
            <form action="delete_hallgato.php" method="POST">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-danger" type="submit" value="Hallgató törlése" name="h_delete">
                    </div>
                </fieldset>
            </form>
            <form action="hallgato_kepzese_felvitel.php" method="POST">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-warning" type="submit" value="Hallgató képzésének felvitele" name="h_kepzes">
                    </div>
                </fieldset>
            </form>
            <form action="kimutatasok.php" method="POST">
                <br>
                <fieldset class="text-center">
                    <div class="buttons">
                        <input class="btn btn-warning" type="submit" value="Kimutatások" name="kimutatas">
                    </div>
                </fieldset>
            </form> <br>
    <?php
        }

    }
     ?>
    <div class="card container-fluid text-center" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Legjobb témavezető témáinak címe</h5>
            <p class="card-text"><?php $array2 = legjobbTemavezetoDolgozatai();
            foreach ($array2 as $item => $value){
                echo $value . "<br>";
            }?></p>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

