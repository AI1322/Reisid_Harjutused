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
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        th { background: lightgrey; }
    </style>
</head>
<body>
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
</body>
</html>