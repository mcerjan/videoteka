<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <style>
        p {display:inline; font-size: 15px;}
        </style>
        <title>Videoteka</title>
    </head>
    <body>
        <?php
        require 'konekcija.php';

        $ispis = range("A", "Z");

        echo '<center>';
        foreach ($ispis as $kljuc => $vrijednost) {
            echo
            '<p><a href="index.php?id=' . $vrijednost . '">'
            . " |" . $vrijednost . " |</a></p>";
        }
        echo '</center><br/>';

        if (isset($_GET['id'])) {
        $query_temp = "SELECT slika,naslov,godina,trajanje FROM filmovi 
         WHERE naslov LIKE ?";
        $film = "".$_GET['id']."%";

        if ($stmt = $db->prepare($query_temp)) {
            $stmt->bind_param('s', $film);
            $stmt->execute();
            $stmt->bind_result($rezultat1, $rezultat2, $rezultat3, $rezultat4);
            while ($stmt->fetch()) {
                echo '<center><img src="' . $rezultat1 . '" height="314" width="217" ><br/>';
                echo '<i>' . $rezultat2 . ' (' . $rezultat3 . ')</i><br/>';
                echo '<i>Trajanje: ' . $rezultat4 . ' min</i>';
            }
            $stmt->close();
        }
        $db->close();
        }
        ?>
    </body>
</html>
