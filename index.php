<?php
$file = "Reisid.json";
global $data;
$data = json_decode(file_get_contents($file), true);

function otsing($otsing, $kriterium){
    $data = json_decode(file_get_contents("Reisid.json"), true);
    $leitud = array();
    $otsing = strtolower(trim($otsing));

    foreach ($data->andmed as $andmed) {
        $var = strtolower(trim($andmed->$kriterium));
        if ($var === $otsing) {
            $leitud[] = $andmed;
        }
    }
    return $leitud;
}

?>


<!DOCTYPE html>
<html lang="ee">
<head>
    <meta charset="UTF-8">
    <title>Reisid</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Avaleht</a></li>
        <li><a href="Reisid_jquery.html">Reisid</a></li>
    </ul>
</nav>
<h1>PHP Reisid</h1>
<div>
    <h3>Otsing</h3>
    <form action="welcome.php" method="POST">
        Päiring: <input type="text" id="search_id" name="search"><br>
        <input type="submit">
    </form>
    <h3>Reiside tabel</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Reisi number</th>
            <th>Lennufirma</th>
            <th>Sihtkoht</th>
            <th>Väljumine</th>
            <th>Saabumine</th>
            <th>Algus aeg</th>
            <th>Lõpp aeg</th>
            <th>Hind (€)</th>
        </tr>
        <?php foreach($data["Reis"] as $reis): ?>
            <tr>
                <td><?= $reis["@attributes"]["id"] ?></td>
                <td><?= $reis["@attributes"]["reisi_number"] ?></td>
                <td><?= $reis["Lennufirma"] ?></td>
                <td><?= $reis["Sihtkoht"] ?></td>
                <td><?= $reis["Lennujaamad"]["Valjumine"] ?></td>
                <td><?= $reis["Lennujaamad"]["Saabumine"] ?></td>
                <td><?= $reis["Lennujaamad"]["@attributes"]["algus_aeg"] ?></td>
                <td><?= $reis["Lennujaamad"]["@attributes"]["loppu_aev"] ?></td>
                <td><?= $reis["Hind"]["@attributes"]["value"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Kood</h3>
    <div class="failid">
        <form method="post">
            <button type="submit" name="action" value="php">PHP</button>
            <button type="submit" name="action" value="xml">XML</button>
            <button type="submit" name="action" value="css">CSS</button>
        </form>
    </div>
    <?php
    // koodi kuvamiseks faili valimine
    $file = null;
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'php') {
            $file = 'index.php';
        } elseif ($_POST['action'] == 'xml') {
            $file = 'Reisid.xml';
        } elseif ($_POST['action'] == 'css') {
            $file = 'styles.css';
        }
    }
    ?>
    <?php
    // faili koodi kuvamine
    if ($file) {
        echo "<div id='code'>";
        echo "<h3>$file</h3>";
        highlight_file($file);
        echo "</div>";
    }
    ?>
</div>

</body>
</html>