<?php
$file = "Reisid2.json";
$data = json_decode(file_get_contents($file), true);

if (isset($_REQUEST['firma'], $_REQUEST['sihtkoht'], $_REQUEST['valjumine'], $_REQUEST['saabumine'], $_REQUEST['hind'])) {
    $firma = trim($_REQUEST['firma']);
    $sihtkoht = trim($_REQUEST['sihtkoht']);
    $valjumine = trim($_REQUEST['valjumine']);
    $saabumine = trim($_REQUEST['saabumine']);
    $kestus = trim($_REQUEST['kestus']);
    $transport_tuup = trim($_REQUEST['transport_tuup']);
    $transport_hind = (float)($_REQUEST['transport'] ?? 0);
    $majutus = (float)($_REQUEST['majutus'] ?? 0);
    $ekskursioonid = (float)($_REQUEST['ekskursioonid'] ?? 0);
    $muudkulud = (float)($_REQUEST['muudkulud'] ?? 0);
    $hind = (float)($_REQUEST['hind']);

    if (!empty($firma) && !empty($sihtkoht) && !empty($valjumine) && !empty($saabumine) && $hind > 0) {
        $newId = count($data["Reisid"]["Reis"]) + 1;
        $newReisiNr = sprintf("%04d-%04d", rand(1000,9999), rand(1000,9999));

        $newReis = [
                "@attributes" => [
                        "id" => (string)$newId,
                        "reisi_number" => $newReisiNr
                ],
                "Firma" => $firma,
                "Sihtkoht" => $sihtkoht,
                "Lennujaamad" => [
                        "@attributes" => [
                                "kestus" => $kestus
                        ],
                        "Valjumine" => $valjumine,
                        "Saabumine" => $saabumine
                ],
                "Transport" => [
                        "@attributes" => [
                                "tuup" => $transport_tuup,
                                "value" => (string)$transport_hind
                        ]
                ],
                "Majutus" => [
                        "@attributes" => [
                                "value" => (string)$majutus
                        ]
                ],
                "Ekskursioonid" => [
                        "@attributes" => [
                                "value" => (string)$ekskursioonid
                        ]
                ],
                "MuudKulud" => [
                        "@attributes" => [
                                "value" => (string)$muudkulud
                        ]
                ],
                "Hind" => [
                        "@attributes" => [
                                "value" => (string)$hind
                        ]
                ]
        ];

        $data["Reisid"]["Reis"][] = $newReis;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = "Uus reis lisatud!";
    } else {
        $message = "Täitke kõik väljad!";
    }
}
?>
<!DOCTYPE html>
<html lang="ee">
<head>
    <meta charset="UTF-8">
    <title>Lisa uus reis</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">PHP</a></li>
        <li><a href="Reisid_jquery.html">JQERY</a></li>
        <li><a href="lisamine.php">Lisamine</a></li>
    </ul>
</nav>

<h1>Reisi lisamine</h1>
<?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>

<form method="post">
    <label>Firma: <input type="text" name="firma" required></label>
    <label>Sihtkoht: <input type="text" name="sihtkoht" required></label>
    <label>Kestus (tt:mm): <input type="text" name="kestus" placeholder="3:15"></label>
    <label>Väljumine: <input type="text" name="valjumine" required></label>
    <label>Saabumine: <input type="text" name="saabumine" required></label>
    <label>Transport tüüp:
        <select name="transport_tuup">
            <option value="Lennureis">Lennureis</option>
            <option value="Buss">Buss</option>
            <option value="Laev">Laev</option>
        </select>
    </label>
    <label>Hind (€): <input type="number" name="hind" step="0.01" required></label>
    <label>Transport (€): <input type="number" name="transport" step="0.01"></label>
    <label>Majutus (€): <input type="number" name="majutus" step="0.01"></label>
    <label>Ekskursioonid (€): <input type="number" name="ekskursioonid" step="0.01"></label>
    <label>Muud kulud (€): <input type="number" name="muudkulud" step="0.01"></label>
    <input type="submit" value="Lisa reis">
</form>

</body>
</html>
