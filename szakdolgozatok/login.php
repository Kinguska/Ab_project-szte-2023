<?php
require_once "database_functions.php";
session_start();


$message = "";
$message2 = "";
if(isset($_POST["Belépés"])) {
    $errors = [];
    if (!isset($_POST["egyetemi_azonosito"]) || trim($_POST["egyetemi_azonosito"]) === "") {
        $errors[] = "Add meg az egyetemi azonosítódat!";
    }
    if (!isset($_POST["password"]) || trim($_POST["password"]) === "") {
        $errors[] = "Add meg a jelszavadat!";
    }

    if (count($errors) === 0) {
        $azonosito = $_POST["egyetemi_azonosito"];
        $password = $_POST["password"];

        if(loginCheck($azonosito)){
            $passwordcheck = "";
            foreach (passwordCheck($azonosito) as $row => $value){
                $passwordcheck = $value;
                break;
            }
            if (password_verify($password, $passwordcheck)) {
                $_SESSION["egyetemi_azonosito"] = $azonosito;
                $_SESSION["password"] = $password;
                $message = "Sikeres bejelentkezés! Pár másodperc múlva beléptetünk!";
                header("refresh:3; url=Szakdolgozatok.php");
            }
            else{
                $message2 = "Nem megfelelő jelszó!";
            }
        }
        else{
            $message2 = "Nincs ilyen azonosító!";
        }
    }
    else{
        $message2 = implode("<br>", $errors);
    }

}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset='utf-8'>
    <title>Bejelentkezés - Szakdolgozatok</title>
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
                    <a class="nav-link active link-secondary text-uppercase" href="login.php">Bejelentkezés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-dark text-uppercase" aria-current="page" href="hallgato_regist.php">Hallgatói regisztráció</a>
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
            <div class="text-center">
                <h2 class="text-center">
                    Bejelentkezés
                </h2>
                <form action="login.php" method="POST" id="login">
                    <fieldset>
                        <strong style="font-size: large">
                            Jelenkezz be, ha van már fiókod vagy ha most regisztráltál! <br> <br>
                        </strong>
                        <strong class="text-uppercase">
                            <?php if ($message != ""){?>
                                <div class="alert alert-success" role="alert">
                                    <?php
                                    echo $message;
                                    ?>
                                </div>
                            <?php } ?>
                        </strong> <br>
                        <label for="egyetemi_azonosito" class="form-label required-label" >Egyetemi azonosító: </label>
                        <input class="form-control" type="text" name="egyetemi_azonosito" id="egyetemi_azonosito"
                        value="<?php if (isset($_POST["egyetemi_azonosito"])) echo $_POST["egyetemi_azonosito"]?>"><br>
                        <label for="password" class="form-label required-label">Jelszó: </label>
                        <input class="form-control" type="password" name="password" id="password"><br>
                        <div class="buttons">
                            <input class="btn btn-secondary" type="submit" value="Belépés" name="Belépés">
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
        <hr>
        <section>
            <div class = "d-grid gap-2 col-4 mx-auto">
                <h2 class="text-center">
                    Regisztráció <br>
                </h2>
                <a class="btn btn-lg btn-info " href="hallgato_regist.php" role="button">Hallgatói regisztráció</a> <br>
                <a class="btn btn-lg btn-success" href="temavezeto_regist.php" role="button">Témavezetői regisztráció</a> <br>
                <a class="btn btn-lg btn-warning" href="admin_regist.php" role="button">Admin regisztráció</a> <br>
            </div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>