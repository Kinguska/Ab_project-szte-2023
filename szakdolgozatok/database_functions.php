<?php


function connectToDatabase()
{
    $connect = mysqli_connect("localhost", "root", "", "szakdolgozatok") or die("Hibás csatlakozás!");

    mysqli_query($connect, 'SET NAMES UTF8');
    mysqli_query($connect, "SET character_set_results=utf8");
    mysqli_set_charset($connect, 'utf8');
    return $connect;
}


function loginCheck($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.személy WHERE személy.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        return false;
    }
    mysqli_close($connect);
    return true;
}

function passwordCheck($egyetemi_azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT személy.jelszó FROM szakdolgozatok.személy WHERE személy.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $egyetemi_azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    $return = $res->fetch_assoc();
    mysqli_close($connect);
    return $return;

}


function szakdolgozatCheck($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.szakdolgozat WHERE szakdolgozat.`dolgozat azonosítója` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        return false;
    }
    mysqli_close($connect);
    return true;
}


function szakdolgozatokInsert($dolgozat_azonositoja, $dolgozat_cime, $tanszek, $beadas_eve, $vedes_eve, $vedes_erdemjegye, $egyetemi_azonosito, $szak_azonosito)
{
    if ($beadas_eve == "") {
        $beadas_eve = NULL;
    }
    if ($vedes_eve == "") {
        $vedes_eve = NULL;
    }
    if ($vedes_erdemjegye == "") {
        $vedes_erdemjegye = NULL;
    }

    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.szakdolgozat VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiiss", $dolgozat_azonositoja, $dolgozat_cime, $tanszek, $beadas_eve, $vedes_eve, $vedes_erdemjegye, $egyetemi_azonosito, $szak_azonosito);
    $stmt->execute();

    mysqli_close($connect);
}


function szemelyInsert($egyetemi_azonosito, $nev, $elotag, $jelszo, $munkakori_beosztas)
{
    $connect = connectToDatabase();
    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.személy VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $egyetemi_azonosito, $nev, $elotag, $jelszo, $munkakori_beosztas);
    $stmt->execute();

    mysqli_close($connect);
}

function hallgatoInsert($egyetemi_azonosito, $jogviszony)
{
    $connect = connectToDatabase();
    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.hallgató VALUES (?, ?)");
    $stmt->bind_param("ss", $egyetemi_azonosito, $jogviszony);
    $stmt->execute();

    mysqli_close($connect);
}

function temavezetoInsert($egyetemi_azonosito, $szerepkor)
{
    $connect = connectToDatabase();
    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.témavezető VALUES (?, ?)");
    $stmt->bind_param("ss", $egyetemi_azonosito, $szerepkor);
    $stmt->execute();

    mysqli_close($connect);
}

function adminInsert($egyetemi_azonosito)
{
    $connect = connectToDatabase();
    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.adminisztrátor VALUES (?)");
    $stmt->bind_param("s", $egyetemi_azonosito);
    $stmt->execute();

    mysqli_close($connect);
}


function szemelyData($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT személy.név, személy.előtag, személy.`munkaköri beosztás` FROM szakdolgozatok.személy WHERE személy.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    $return = $res->fetch_assoc();

    mysqli_close($connect);
    return $return;
}


function azonositoCheck($egyetemi_azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.személy WHERE személy.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $egyetemi_azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        return false;
    }

    mysqli_close($connect);
    return true;
}


function ishallgato($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.hallgató WHERE hallgató.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        mysqli_close($connect);
        return false;
    }

    mysqli_close($connect);
    return true;
}

function istemavezeto($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.témavezető WHERE témavezető.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        mysqli_close($connect);
        return false;
    }

    mysqli_close($connect);
    return true;
}

function isadmin($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.adminisztrátor WHERE adminisztrátor.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        mysqli_close($connect);
        return false;
    }

    mysqli_close($connect);
    return true;
}


function szakdolgozatCimModify($azonosito, $uj_cim)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "UPDATE szakdolgozatok.szakdolgozat SET szakdolgozat.`dolgozat címe` = ? WHERE szakdolgozat.`dolgozat azonosítója` = ?");
    $stmt->bind_param("ss", $uj_cim, $azonosito);
    $stmt->execute();

    mysqli_close($connect);
}


function isTemavezetoBelso($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.témavezető WHERE témavezető.`egyetemi azonosító` = ? AND témavezető.`szerepkör` = 'belső'");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        mysqli_close($connect);
        return false;
    }

    mysqli_close($connect);
    return true;

}


function szakdolgozatokTemavezetoKiir($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT téma.`egyetemi azonosító`, személy.név, téma.`dolgozat azonosítója`, szakdolgozat.`dolgozat címe`
       FROM szakdolgozatok.szakdolgozat 
    INNER JOIN szakdolgozatok.téma ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója`
         INNER JOIN szakdolgozatok.témavezető ON téma.`egyetemi azonosító` = témavezető.`egyetemi azonosító`
            INNER JOIN szakdolgozatok.személy ON témavezető.`egyetemi azonosító` = személy.`egyetemi azonosító`
                WHERE témavezető.`egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);

    $stmt->execute();
    $res = $stmt->get_result();
    if (mysqli_num_rows($res) == 0) {
        echo "<br>";
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<h2 class='text-center text-uppercase'>Még nem vagy témavezető egy szakdolgozatnál sem! </h2>";
        echo "<h2 class='text-center text-uppercase'>Egy adminisztrátor tud hozzárendelni a dolgozat(ok)hoz!</h2>";
        echo "</div>";
        return;
    }

    echo "<table class='table table-success container-fluid'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>Témavezető azonosítója</th>";
    echo "<th scope='col'>Témavezető neve</th>";
    echo "<th scope='col'>Dolgozat azonosítója</th>";
    echo "<th scope='col'>Dolgozat címe</th>";
    if (isTemavezetoBelso($_SESSION['egyetemi_azonosito'])) {
        echo "<th scope='col'>Módosítás</th>";
    }
    echo "</tr>";
    echo "</thead>";

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $current_row["egyetemi azonosító"] . "</td>";
        echo "<td>" . $current_row["név"] . "</td>";
        echo "<td>" . $current_row["dolgozat azonosítója"] . "</td>";
        $azonosito = $current_row["dolgozat azonosítója"];
        echo "<td>" . $current_row["dolgozat címe"] . "</td>";
        if (isTemavezetoBelso($_SESSION['egyetemi_azonosito'])) {
            echo "<td><form method='get' action='szakdolgozat_nev_valtoztatas.php'>
                <input type='hidden' name='azonosito' value='$azonosito'>
                <button type='submit' class='btn btn-success'>Cím módosítása</button>
            </form></td>";
        }
        echo "</tr>";

    }
    echo "</tbody>";
    echo "</table>";
}



function szakdolgozatok(){
    $connect = connectToDatabase();

    $query = "SELECT szakdolgozat.`dolgozat azonosítója` FROM szakdolgozatok.szakdolgozat ORDER BY szakdolgozat.`dolgozat azonosítója` ASC";
    $res = mysqli_query($connect, $query);
    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[] = $current_row["dolgozat azonosítója"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;
}


function tanszekek()
{
    $connect = connectToDatabase();

    $query = "SELECT `tanszék` FROM szakdolgozatok.tanszék ORDER BY `tanszék` ASC ";
    $res = mysqli_query($connect, $query);
    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[] = $current_row["tanszék"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;
}


function szakok()
{
    $connect = connectToDatabase();

    $query = "SELECT `szak azonosítója`, `szak neve` FROM szakdolgozatok.szak ORDER BY `szak neve` ASC";
    $res = mysqli_query($connect, $query);
    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[$current_row["szak azonosítója"]] = $current_row["szak neve"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;
}


function hallgatok()
{
    $connect = connectToDatabase();

    $query = "SELECT `egyetemi azonosító` FROM szakdolgozatok.hallgató ORDER BY `egyetemi azonosító` ASC";
    $res = mysqli_query($connect, $query);
    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[] = $current_row["egyetemi azonosító"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;
}


function temavezetok()
{
    $connect = connectToDatabase();

    $query = "SELECT `egyetemi azonosító` FROM szakdolgozatok.témavezető ORDER BY `egyetemi azonosító` ASC";
    $res = mysqli_query($connect, $query);
    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[] = $current_row["egyetemi azonosító"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;

}



function eventeDolgozatokTemavezetonkent(){
    $connect = connectToDatabase();

    $query = "SELECT COUNT(szakdolgozat.`dolgozat azonosítója`), szakdolgozat.`beadás éve`, személy.`egyetemi azonosító`, személy.név 
    FROM szakdolgozatok.szakdolgozat
    INNER JOIN szakdolgozatok.téma 
        ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója`
    INNER JOIN szakdolgozatok.személy 
        ON szakdolgozatok.téma.`egyetemi azonosító` = személy.`egyetemi azonosító`
    WHERE `beadás éve` IS NOT NULL
    GROUP BY személy.`egyetemi azonosító`, szakdolgozat.`beadás éve`, személy.név
   	ORDER BY szakdolgozat.`beadás éve` DESC, személy.`egyetemi azonosító` ASC";

    $res = mysqli_query($connect, $query);

    echo '<table class="table table-warning container-fluid">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Beadás éve</th>';
    echo '<th scope="col">Témavezető azonosítója</th>';
    echo '<th scope="col">Témavezető neve</th>';
    echo '<th scope="col">Dolgozatok száma</th>';
    echo '</tr>';
    echo '</thead>';

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $current_row["beadás éve"] . '</td>';
        echo '<td>' . $current_row["egyetemi azonosító"] . '</td>';
        echo '<td>' . $current_row["név"] . '</td>';
        echo '<td>' . $current_row["COUNT(szakdolgozat.`dolgozat azonosítója`)"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';


    mysqli_close($connect);
}



function eventeDolgozatokTanszekenkent(){
    $connect = connectToDatabase();

    $query = "SELECT COUNT(szakdolgozat.`dolgozat azonosítója`), szakdolgozat.`beadás éve`, szakdolgozat.tanszék
        FROM szakdolgozatok.szakdolgozat
        INNER JOIN szakdolgozatok.tanszék 
            ON szakdolgozat.tanszék = tanszék.tanszék
        WHERE `beadás éve` IS NOT NULL 
        GROUP BY szakdolgozat.`beadás éve`, tanszék
        ORDER BY szakdolgozat.`beadás éve` DESC, tanszék ASC";

    $res = mysqli_query($connect, $query);

    echo '<table class="table table-warning container-fluid">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Tanszék</th>';
    echo '<th scope="col">Beadás éve</th>';
    echo '<th scope="col">Dolgozatok száma</th>';
    echo '</tr>';
    echo '</thead>';

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $current_row["tanszék"] . '</td>';
        echo '<td>' . $current_row["beadás éve"] . '</td>';
        echo '<td>' . $current_row["COUNT(szakdolgozat.`dolgozat azonosítója`)"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';


    mysqli_close($connect);
}


function eventeSikeresVedesek($azonosito){
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT COUNT(szakdolgozat.`védés érdemjegye`), szakdolgozat.`védés éve`
        FROM szakdolgozatok.szakdolgozat
        INNER JOIN szakdolgozatok.téma 
            ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója`
        INNER JOIN szakdolgozatok.személy 
            ON téma.`egyetemi azonosító` = személy.`egyetemi azonosító`
        WHERE `védés éve` IS NOT NULL AND `védés érdemjegye` > 1 AND személy.`egyetemi azonosító` = ?
        GROUP BY szakdolgozat.`védés éve`
        ORDER BY szakdolgozat.`védés éve` DESC");
    $stmt->bind_param("s", $azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    echo '<table class="table table-success container-fluid">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Védés éve</th>';
    echo '<th scope="col">Sikeres védések száma</th>';
    echo '</tr>';
    echo '</thead>';

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $current_row["védés éve"] . '</td>';
        echo '<td>' . $current_row["COUNT(szakdolgozat.`védés érdemjegye`)"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';


    mysqli_close($connect);

}



function isHallgatoSzakInKepzese($egyetemi_azonosito, $szak_azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.képzése WHERE képzése.`egyetemi azonosító` = ? AND képzése.`szak azonosítója` = ?");
    $stmt->bind_param("ss", $egyetemi_azonosito, $szak_azonosito);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) == 0) {
        mysqli_close($connect);
        return false;
    }

    mysqli_close($connect);
    return true;

}


function hallgatoKepzeseInsert($egyetemi_azonosito, $szak_azonosito, $kezdes, $vegzes, $diploma_sorszama)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.képzése 
    (képzése.`egyetemi azonosító`, képzése.`szak azonosítója`, képzése.`kezdés szemesztere`, képzése.`végzés szemesztere`, 
     képzése.`diploma sorszáma`) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss", $egyetemi_azonosito, $szak_azonosito, $kezdes, $vegzes, $diploma_sorszama);
    $stmt->execute();

    mysqli_close($connect);
}


function szakdolgozatokKiir($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT szakdolgozat.`dolgozat azonosítója`, szakdolgozat.`dolgozat címe`, szakdolgozat.tanszék, 
       szakdolgozat.`beadás éve`, szakdolgozat.`védés éve`, szakdolgozat.`védés érdemjegye`, szakdolgozat.`egyetemi azonosító`, 
       szakdolgozat.`szak azonosítója`, tanszék.intézet, tanszék.`kar azonosító`, kar.`kar neve`, személy.név, szak.`szak neve` 
        FROM szakdolgozatok.szakdolgozat
    INNER JOIN szakdolgozatok.tanszék 
        ON szakdolgozat.tanszék = tanszék.tanszék
    INNER JOIN szakdolgozatok.kar 
        ON tanszék.`kar azonosító` = kar.`kar azonosító` 
    LEFT JOIN szakdolgozatok.téma 
        ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója`
    LEFT JOIN szakdolgozatok.személy 
        ON téma.`egyetemi azonosító` = személy.`egyetemi azonosító`
    LEFT JOIN szakdolgozatok.szak 
        ON szakdolgozat.`szak azonosítója` = szak.`szak azonosítója`
    WHERE szakdolgozat.`egyetemi azonosító` = ? 
    ORDER BY `védés éve` DESC");
    $stmt->bind_param("s", $azonosito);

    $stmt->execute();
    $res = $stmt->get_result();

    echo '<table class="table table-info container-fluid">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Dolgozat azonosítója</th>';
    echo '<th scope="col">Dolgozat címe</th>';
    echo '<th scope="col">Beadás éve</th>';
    echo '<th scope="col">Védés éve</th>';
    echo '<th scope="col">Védés érdemjegye</th>';
    echo '<th scope="col">Hallgatói egyetemi azonosító</th>';
    echo '<th scope="col">Tanszék</th>';
    echo '<th scope="col">Intézet</th>';
    echo '<th scope="col">Kar</th>';
    echo '<th scope="col">Szak neve</th>';
    echo '<th scope="col">Témavezető neve</th>';
    echo '</tr>';
    echo '</thead>';

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $current_row["dolgozat azonosítója"] . '</td>';
        echo '<td>' . $current_row["dolgozat címe"] . '</td>';
        if ($current_row["beadás éve"] == 0)
            echo '<td>' . " " . '</td>';
        else {
            echo '<td>' . $current_row["beadás éve"] . '</td>';
        }
        if ($current_row["védés éve"] == 0)
            echo '<td>' . " " . '</td>';
        else {
            echo '<td>' . $current_row["védés éve"] . '</td>';
        }
        if ($current_row["védés érdemjegye"] == 0)
            echo '<td>' . " " . '</td>';
        else {
            echo '<td>' . $current_row["védés érdemjegye"] . '</td>';
        }
        echo '<td>' . $azonosito . '</td>';
        echo '<td>' . $current_row["tanszék"] . '</td>';
        echo '<td>' . $current_row["intézet"] . '</td>';
        echo '<td>' . $current_row["kar neve"] . '</td>';
        echo '<td>' . $current_row["szak neve"] . '</td>';
        echo '<td>' . $current_row["név"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';


    mysqli_close($connect);
}

function szemelyKiir()
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.személy");
    $stmt->execute();
    $res = $stmt->get_result();

    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">egyetemi azonosító</th>';
    echo '<th scope="col">név</th>';
    echo '<th scope="col">előtag</th>';
    echo '<th scope="col">munkaköri beosztás</th>';
    echo '</tr>';
    echo '</thead>';

    while (($current_row = mysqli_fetch_assoc($res)) != null) {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $current_row["egyetemi azonosító"] . '</td>';
        echo '<td>' . $current_row["név"] . '</td>';
        echo '<td>' . $current_row["előtag"] . '</td>';
        echo '<td>' . $current_row["munkaköri beosztás"] . '</td>';
        echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';

    mysqli_free_result($res);
    mysqli_close($connect);
}


function szakdolgozatTorol($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "DELETE FROM szakdolgozatok.szakdolgozat WHERE `dolgozat azonosítója` = ?");
    $stmt->bind_param("s", $azonosito);

    $stmt->execute();

    mysqli_close($connect);
}


function isHallgatoLetezik($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.hallgató WHERE `egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);

    $stmt->execute();
    $res = $stmt->get_result();

    $row = mysqli_fetch_assoc($res);

    mysqli_close($connect);

    if ($row == null) {
        return false;
    } else {
        return true;
    }
}


function szemelyTorol($azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "DELETE FROM szakdolgozatok.személy WHERE `egyetemi azonosító` = ?");
    $stmt->bind_param("s", $azonosito);

    $stmt->execute();

    mysqli_close($connect);
}


function isSzakdolgozatLetezik($dolgozat_azonosito)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.szakdolgozat WHERE `dolgozat azonosítója` = ?");
    $stmt->bind_param("s", $dolgozat_azonosito);

    $stmt->execute();
    $res = $stmt->get_result();

    $row = mysqli_fetch_assoc($res);

    mysqli_close($connect);

    if ($row == null) {
        return false;
    } else {
        return true;
    }
}


function temavezetoInTema($dolgozat_azonosito, $temavezeto)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT * FROM szakdolgozatok.téma WHERE `dolgozat azonosítója` = ? AND `egyetemi azonosító` = ?");
    $stmt->bind_param("ss", $dolgozat_azonosito, $temavezeto);

    $stmt->execute();
    $res = $stmt->get_result();

    $row = mysqli_fetch_assoc($res);

    mysqli_close($connect);

    if ($row == null) {
        return false;
    } else {
        return true;
    }
}


function temavezetoHozzarendelSzakdolgozathoz($dolgozat_azonosito, $temavezeto)
{
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "INSERT INTO szakdolgozatok.téma (`dolgozat azonosítója`, `egyetemi azonosító`) VALUES (?, ?)");
    $stmt->bind_param("ss", $dolgozat_azonosito, $temavezeto);

    $stmt->execute();


    mysqli_close($connect);
}


function legjobbTemavezetoDolgozatai(){
    $connect = connectToDatabase();

    $stmt = mysqli_prepare($connect, "SELECT szakdolgozat.`dolgozat címe` FROM szakdolgozatok.szakdolgozat 
    INNER JOIN szakdolgozatok.téma 
        ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója` 
    WHERE téma.`egyetemi azonosító` = (SELECT személy.`egyetemi azonosító`
                    FROM szakdolgozatok.szakdolgozat
                    INNER JOIN szakdolgozatok.téma 
                        ON szakdolgozat.`dolgozat azonosítója` = téma.`dolgozat azonosítója`
                    INNER JOIN szakdolgozatok.személy 
                        ON téma.`egyetemi azonosító` = személy.`egyetemi azonosító`
                    WHERE `védés éve` IS NOT NULL AND `védés érdemjegye` > 1 
                    GROUP BY személy.`egyetemi azonosító`, személy.név
                    ORDER BY COUNT(szakdolgozat.`dolgozat azonosítója`) DESC, személy.név ASC LIMIT 1)");
    $stmt->execute();
    $res = $stmt->get_result();

    $array = [];
    if (mysqli_num_rows($res) > 0) {
        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            $array[] = $current_row["dolgozat címe"];
        }
        mysqli_close($connect);
        return $array;
    }
    mysqli_close($connect);
    return null;
}




?>

<style>
    /*table border */
    table, th, td {
        border: 1px solid black;
    }
</style>
