<?php
$file = "Reisid.json";
$data = json_decode(file_get_contents($file), true);

function otsing($otsing, $kriterium){
    $data = json_decode(file_get_contents("Reisid.json"), true);
    $leitud = [];
    $otsing = strtolower(trim($otsing));

    foreach ($data["Reisid"]["Reis"] as $reis) {
        if ($kriterium === "Sihtkoht" || $kriterium === "Firma") {
            $var = strtolower(trim($reis[$kriterium]));
            if (strpos($var, $otsing) !== false) {
                $leitud[] = $reis;
            }
        }
    }
    return $leitud;
}

if (!empty($_POST['search']) && !empty($_POST['kriterium'])) {
    $tulemused = otsing($_POST['search'], $_POST['kriterium']);
} else {
    $tulemused = $data["Reisid"]["Reis"];
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
<h1 class="failid">PHP Reisid</h1>
<div>
    <div class="failid">
        <form method="POST">
            Otsing: <input type="text" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
            <select name="kriterium">
                <option value="Sihtkoht" <?= (isset($_POST['kriterium']) && $_POST['kriterium']=="Sihtkoht") ? "selected" : "" ?>>Sihtkoht</option>
                <option value="Firma" <?= (isset($_POST['kriterium']) && $_POST['kriterium']=="Firma") ? "selected" : "" ?>>Firma</option>
            </select>
            <input type="submit" value="Otsi">
        </form>
    </div>

    <h3 class="failid">Reiside nimekiri</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Reisi number</th>
            <th>Firma</th>
            <th>Sihtkoht</th>
            <th>Kestus</th>
            <th>Väljumine</th>
            <th>Saabumine</th>
            <th>Hind (€)</th>
            <th>Kogumaksumus (€)</th>
        </tr>
        <?php if (empty($tulemused)): ?>
            <tr><td colspan="9" style="text-align:center;">Midagi ei leitud</td></tr>
        <?php else: ?>
            <?php foreach($tulemused as $reis): ?>
                <?php
                $transp = (float)$reis["Transport"]["@attributes"]["value"];
                $majutus = (float)$reis["Majutus"]["@attributes"]["value"];
                $eksk = (float)$reis["Ekskursioonid"]["@attributes"]["value"];
                $muud = (float)$reis["MuudKulud"]["@attributes"]["value"];
                $kogumaksumus = $transp + $majutus + $eksk + $muud;
                ?>
                <tr>
                    <td><?= $reis["@attributes"]["id"] ?></td>
                    <td><?= $reis["@attributes"]["reisi_number"] ?></td>
                    <td><?= $reis["Firma"] ?></td>
                    <td><?= $reis["Sihtkoht"] ?></td>
                    <td><?= $reis["Lennujaamad"]["@attributes"]["kestus"] ?></td>
                    <td><?= $reis["Lennujaamad"]["Valjumine"] ?></td>
                    <td><?= $reis["Lennujaamad"]["Saabumine"] ?></td>
                    <td><?= $reis["Hind"]["@attributes"]["value"] ?></td>
                    <td><?= $kogumaksumus ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <h3 class="failid">Kood</h3>
    <div class="failid">
        <form method="post">
            <button type="submit" name="action" value="php">PHP</button>
            <button type="submit" name="action" value="xml">XML</button>
            <button type="submit" name="action" value="json">JSON</button>
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
        } elseif ($_POST['action'] == 'json') {
            $file = 'Reisid.json';
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
