<?php
require_once "database_functions.php";
session_start();

$message = "";
$message2 = "";

if(isset($_POST["Regisztrálás"])){

    $errors2 = [];
    if (!isset($_POST["egyetemi_azonosito"]) || trim($_POST["egyetemi_azonosito"]) === "" )  {
        $errors2[] = "Add meg az egyetemi azonosítódat!";
    }
    if (!isset($_POST["nev"]) || trim($_POST["nev"]) === "" )  {
        $errors2[] = "Add meg a nevedet!";
    }
    $_POST["elotag"] = isset($_POST["elotag"]) ? $_POST["elotag"] : "";
    $_POST["munkakori_beosztas"] = "hallgató";
    if (isset($_POST["jogviszony"])){
        $_POST["jogviszony"] = "aktív";
    } else {
        $_POST["jogviszony"] = "passzív";
    }


    if (!isset($_POST["password1"]) || trim($_POST["password1"]) === "") {
        $errors2[] = "Add meg a jelszót!";
    }
    if (!isset($_POST["password2"]) || trim($_POST["password2"]) === "") {
        $errors2[] = "Add meg a jelszót mégegyszer!";
    }

    if (count($errors2) === 0) {
        $azonosito = $_POST["egyetemi_azonosito"];
        $nev = $_POST["nev"];
        $elotag = $_POST["elotag"];
        $munkakor = $_POST["munkakori_beosztas"];
        $jogviszony = $_POST["jogviszony"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        if (strlen($azonosito) > 10){
            $errors2[] = "Az egyetemi azonosító nem lehet hosszabb 10 karakternél!";
        }

        if(azonositoCheck($azonosito)){
            $errors2[] = "Ez az azonosító már foglalt!";
        }
        if (strlen($password1) < 6) {
            $errors2[] = "A jelszó nem elég hosszú!";
        }
        if ($password2 != $password1) {
            $errors2[] = "A két jelszó nem egyezik meg!";
        }
        if(count($errors2) === 0){
            $password = password_hash($password1, PASSWORD_DEFAULT);

            szemelyInsert($azonosito, $nev, $elotag, $password, $munkakor);
            hallgatoInsert($azonosito, $jogviszony);
            $message = "Sikeres regisztráció! Kérlek lépj be a '<a class='link-secondary' href='login.php' >Bejelentkezés</a>' oldalon!";
        }
    }

    if (count($errors2) > 0){
        $message2 = implode("<br>", $errors2);
    }


}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Regisztráció1 - Szakdolgozatok</title>
    <link rel="stylesheet" href="style_picture/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
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
                <li class="nav-item">
                    <a class="nav-link link-dark text-uppercase" href="login.php">Bejelentkezés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active link-secondary text-uppercase" aria-current="page" href="hallgato_regist.php">Hallgatói regisztráció</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-dark text-uppercase" href="temavezeto_regist.php">Témavezetői regisztráció</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-dark text-uppercase" href="admin_regist.php">Adminisztrátori regisztráció</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header>
    <br>
    <h1 class="text-center">
        Szakdolgozatok Aranyos Rendszere
    </h1> <br>
</header>
<div class="container bg-light">
    <main >
        <section>
            <div>
                <h2>
                    Regisztráció - Hallgató
                </h2>
                <form action="hallgato_regist.php" method="POST" id="regist_hallgato" class="mb-3">
                    <fieldset>
                        <strong style="font-size: large">
                            Ha még nincs fiókod, regisztrálj! <br><br>
                        </strong>
                        <strong class="text-uppercase text-center">
                            <?php if ($message != ""){?>
                                <div class="alert alert-success" role="alert">
                                    <?php
                                    echo $message;
                                    ?>
                                </div>
                            <?php } ?>
                        </strong> <br>
                        <label for="egyetemi_azonosito" class="form-label required-label">Egyetemi azonosító: </label>
                        <input required class="form-control" type="text" name="egyetemi_azonosito" id="egyetemi_azonosito" placeholder="például ABC123"
                               maxlength="10" value="<?php if (isset($_POST["egyetemi_azonosito"])) echo $_POST["egyetemi_azonosito"] ?>"><br>
                        <label for="nev" class="form-label required-label">Név: </label>
                        <input required class="form-control" type="text" name="nev" id="nev" placeholder="Vezetéknév Keresztnév"
                               maxlength="40" value="<?php if (isset($_POST["nev"])) echo $_POST["nev"] ?>"><br>
                        <label for="elotag" class="form-label">Előtag: </label>
                        <input class="form-control" type="text" name="elotag" id="elotag" placeholder="például Dr."
                               maxlength="10" value="<?php if (isset($_POST["elotag"])) echo $_POST["elotag"] ?>"><br>
                        <input class="form-check-input" type="checkbox" name="jogviszony" value="aktív" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Aktív jogviszony
                        </label> <br><br>
                        <label for="password1" class="form-label required-label">Jelszó: </label>
                        <input required class="form-control" type="password" name="password1" id="password1" aria-describedby="passwordHelpInline"><br>
                        <blockquote id="warning">Legalább 6 karakter hosszú jelszó szükséges!</blockquote>
                        <label for="password2" class="form-label required-label">Jelszó ismét: </label>
                        <input required class="form-control" type="password" name="password2" id="password2"><br>
                        <div class="buttons">
                            <input class="btn btn-info" type="submit" value="Regisztrálás" name="Regisztrálás">
                        </div>
                    </fieldset>
                    <p>
                        <small>
                            *: Adat megadása kötelező!
                        </small>
                    </p>
                </form>
                <strong class="text-uppercase">
                    <?php if ($message2 != ""){?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo $message2;
                            ?>
                        </div>
                    <?php } ?>
                </strong>
            </div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>