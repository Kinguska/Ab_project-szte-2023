<?php
require_once "database_functions.php";
session_start();

szakdolgozatCimModify("azt", "Az ebek eredete2222");

$message = "";
if (isset($_POST["user_delete"])){
    $errors = [];
    if (!isset($_POST["egyetemi_azonosito"]) || trim($_POST["egyetemi_azonosito"]) === "" )  {
        $errors[] = "Add meg az egyetemi azonosítódat!";
    }
    if (!isset($_POST["password"]) || trim($_POST["password"]) === "") {
        $errors[] = "Add meg a jelszavadat!";
    }
    if (!isset($_POST["password2"]) || trim($_POST["password2"]) === "") {
        $errors[] = "Add meg a jelszavadat mégegyszer!";
    }

    if (count($errors) === 0){
        $azonosito = $_POST["egyetemi_azonosito"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];

        if(loginCheck($azonosito)){
            $passwordcheck = "";
            foreach (passwordCheck($azonosito) as $row => $value){
                $passwordcheck = $value;
                break;
            }
            if (password_verify($password, $passwordcheck)) {
                szemelyTorol($azonosito);
                session_unset();
                session_destroy();
                header("Location: login.php");
            }
            else{
                $message = "Nem megfelelő jelszó!";
            }
        }
        else{
            $message = "Nincs ilyen azonosító!";
        }

        if (isHallgatoLetezik($azonosito)){
            szemelyTorol($azonosito);
            $message = "Sikeres törlés!";
        }
        else{
            $message = "Nincs ilyen hallgató!";
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
    <title>Felhasználó törlés</title>
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
            if (isset($_SESSION['egyetemi_azonosito'])){
                ?>
                <div>
                    <form action="delete_szemely.php" method="post" id="delete_h">
                        <fieldset>
                            <label for="egyetemi_azonosito" class="form-label required-label" >Egyetemi azonosító: </label>
                            <input class="form-control" type="text" name="egyetemi_azonosito" id="egyetemi_azonosito" required> <br>
                            <label for="password" class="form-label required-label" >Jelszó: </label>
                            <input class="form-control" type="password" name="password" id="password" required> <br>
                            <label for="password2" class="form-label required-label" >Jelszó ismét: </label>
                            <input class="form-control" type="password" name="password2" id="password2" required> <br>
                            <div class="buttons">
                                <input class="btn btn-danger" type="submit" value="Felhasználó törlése" name="user_delete">
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
        ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>



