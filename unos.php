<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <style>
            .tablica {
                margin: auto;
                position: relative;
                border-collapse: collapse;
                border-spacing: 0;}
            .tablica { border: 0; }
            .tablica td, .tablica th { border: 1px solid black; }
            .prvi { background-color: #efefef; }
            td { text-align: center; }
        </style>
        <title>Unos novog filma u videoteku</title>
    </head>
    <body>
        Unos novog  filma u videoteku:<br/><br/>
        <form method="post" action="" enctype="multipart/form-data">
            Naslov filma:
            <input type="text" name="naslovFilma" size="20"/><br/><br/>
            Odaberite žanr:
            <?php select_za_zanr(); ?><br/><br/>
            Godina:
            <?php select_za_godinu(); ?><br/><br/>
            Trajanje filma:
            <input type="text" name="trajanjeFilma" size="20"/><br/><br/>
            Slika:
            <input type="file" name="slika" value="" /><br/><br/>
            <input type="submit" name="spremi" value="Spremi"/><br/><br/>

            <?php
            require 'konekcija.php';

            function select_za_zanr() {
                require 'konekcija.php';
                echo '<select name="zanr">';
                echo '<option value="0">Odaberite žanr:</option>';
                $query1 = "SELECT * FROM zanr ORDER BY naziv ASC";

                if ($stmt = $db->prepare($query1)) {
                    $stmt->execute();
                    $stmt->bind_result($id, $naziv);
                    while ($stmt->fetch()) {
                        echo '<option value="' . $id . '">' . $naziv . '</option>';
                    }
                    $stmt->close();
                    echo '</select>';
                }
            }

            function select_za_godinu() {
                require 'konekcija.php';
                echo '<select name="godina">';
                echo '<option value="0">Odaberite godinu:</option>';
                for ($i = 2016; $i >= 1900; $i--) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                echo '</select>';
            }

            if (isset($_POST["spremi"])) {
                $dir_za_upload = 'C:\Program Files (x86)\EasyPHP-DevServer-14.1VC9\data\localweb\projects\php_mysql\provjera\Slike';
                $uploadfile = basename($_FILES['slika']['name']);
                move_uploaded_file($_FILES['slika']['tmp_name'], $uploadfile);

                $query2 = "INSERT INTO filmovi(naslov,id_zanr,godina,trajanje,slika) "
                        . "VALUES (?,?,?,?,?)";

                $imeFilma = "" . $_POST['naslovFilma'] . "";
                $zanr = "" . $_POST['zanr'] . "";
                $godina = "" . $_POST['godina'] . "";
                $trajanje = "" . $_POST['trajanjeFilma'] . "";
                $slika = "" . $_FILES["slika"]["name"] . "";

                if ($stmt = $db->prepare($query2)) {
                    $stmt->bind_param('siiis', $imeFilma, $zanr, $godina, $trajanje, $slika);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            echo '<table class="tablica">';
            echo '<tr class="prvi"><th>Slika</th><th>Naslov filma</th><th>Godina</th><th>Trajanje</th><th>Akcija</th></tr>';

            $query3 = "SELECT id,slika,naslov,godina,trajanje FROM filmovi ORDER BY naslov ASC";

            if ($stmt = $db->prepare($query3)) {
                $stmt->execute();
                $stmt->bind_result($id, $slika, $naslov, $godina, $trajanje);
                while ($stmt->fetch()) {
                    echo'<tr>';
                    echo '<td><image src="' . $slika . '" height="148" width="100"></td>';
                    echo '<td>' . $naslov . '</td>';
                    echo '<td>' . $godina . '</td>';
                    echo '<td>' . $trajanje . ' min</td>';
                    echo '<td>[ <a name="brisi" href="unos.php?id=' .
                    $id . '">Obriši</a> ]</td>';
                    echo '</tr>';
                }
                $stmt->close();
            }

            echo'</table>';

            if (isset($_GET['id']) != "") {
                $delete = $_GET['id'];
                $query = mysqli_query($db, "DELETE FROM filmovi WHERE id='$delete'");

                if ($delete) {
                    echo "<meta http-equiv='refresh' content='0;url=unos.php'>";
                } else {
                    echo mysql_error();
                }
            }
            ?>
        </form>
    </body>
</html>


