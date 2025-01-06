<?php

$mysqli = new mysqli("localhost", "ceda8720", "c4Gt-KRWC-UCP(", "ceda8720_projets_72h");

// Vérification de la connexion
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}
?>
