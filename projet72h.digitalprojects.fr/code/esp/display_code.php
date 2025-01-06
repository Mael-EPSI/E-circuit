<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php
session_start();
require('../../php/config/config.php');
$car_name = $_SESSION['car_name'];

$verify_Query = "SELECT * FROM cars WHERE car_username = ?";
$stmt = mysqli_prepare($mysqli, $verify_Query);
mysqli_stmt_bind_param($stmt, "s", $car_name);
mysqli_stmt_execute($stmt);
$verify_Query_Result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($verify_Query_Result) > 0) {
    // Stocker le code dans une variable
    $code = '
#include "WiFi.h";
#include "PubSubClient.h";
#include "Wire.h";
// WiFi
$ssid = {WIFI_NAME}; // Entrez votre SSID WiFi
$password = {WIFI_PASSWORD}; // Entrez votre mot de passe WiFi

// MQTT Broker
$mqtt_broker = "192.168.1.52";
$topic = "esp2";
$topic = "esp2";
$mqtt_username = "Green";
$mqtt_password = "Green";
$mqtt_port = 1883;

$a = true;

$seconde = 1000;
$offset = 0;

$espClient = new WiFiClient();
$client = new PubSubClient($espClient);

void setup() {

  //Mise de la vitesse de transmission à 115200;
  Serial.begin(115200);
  // Connecting to a Wi-Fi network
  $WiFi->begin($ssid, $password);
  while ($WiFi->status() != WL_CONNECTED) {
    delay(500);
    echo "Connecting to WiFi..";
  }
  echo "Connected to the Wi-Fi network";
  //connexion au broker MQTT
  $client->setServer($mqtt_broker, $mqtt_port);
  $client->setCallback("callback");
  while (!$client->connected()) {
    $client_id = "esp32-client-" . $WiFi->macAddress();
    echo "The client $client_id connects to the public MQTT broker";
    if ($client->connect($client_id, $mqtt_username, $mqtt_password)) {
      echo "Public EMQX MQTT broker connected";
    } else {
      echo "failed with state " . $client->state();
      delay(2000);
    }
  }
  // Publish et subscribe
  $client->publish($topic, "Hi, I\'m '. $car_name .'");
  $client->subscribe($topic);
}

// Reception du message MQTT
void callback($topic, $payload, $length) {
  echo "Message arrived in topic: $topic";
  echo "Message:";
  for ($i = 0; $i < $length; $i++) {
    echo chr($payload[$i]);
  }
  echo "-----------------------";
}

void loop() {
  if (millis() - $offset >= $seconde * 5) {
    echo "<br>";
    echo "WiFi connected";
    echo "IP address: " . $WiFi->localIP();
    $offset = millis();
  }
  $client->loop();
}
';

    // Affichage du code et des boutons de copie et de retour
    echo '<div class="container">';
    echo '<pre editable>' . htmlspecialchars($code) . '</pre>';
    echo '<button id="copyBtn"><i class="fa-solid fa-copy fa-2x"></i>Copier le code</button>';
    echo '<button class="Btn" onclick="window.location.href = \'../../index.html\';">';
    echo '<div class="sign">';
    echo '<svg viewBox="0 0 512 512">';
    echo '<path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>';
    echo '</svg>';
    echo '</div>';
    echo '<div class="text">Retour</div>';
    echo '</button>';
    echo '</div>';
} else {
    // Erreur lors de le requête
    $_SESSION['msg_add_car'] = "Une erreur est survenue";
    header("Location: ../../php/Auth/cars/register.php");
    exit();
}
?>
<script>
  document.getElementById("copyBtn").addEventListener("click", function() {
    var code = <?php echo json_encode($code); ?>;
    var tempInput = document.createElement("textarea");
    var btn = document.getElementById("copyBtn");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = code;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    btn.innerHTML  = '<i class="fa-solid fa-copy fa-2x"></i>Copié';
    setTimeout(function() {
      btn.innerHTML  = '<i class="fa-solid fa-copy fa-2x"></i>Copier le code';
    }, 2000);
});
</script>

</body>
</html>
