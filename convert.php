<?php
// Laeme XML faili
$xml = simplexml_load_file("Reisid.xml");

// Täiendame XML objektist JSON-iks
$json = json_encode($xml, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Salvestame faili
file_put_contents("Reisid.json", $json);

echo "Konverteerimine valmis! Vaata faili autod.json";