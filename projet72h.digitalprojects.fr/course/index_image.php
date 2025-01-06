<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require('../php/config/config.php');

// Initialisation de l'array pour stocker les voitures
$carsArray = [];

// Requête préparée pour récupérer toutes les voitures
$query = "SELECT * FROM cars";
$stmt = mysqli_prepare($mysqli, $query);

// Vérification de la préparation de la requête
if ($stmt) {
    // Exécution de la requête
    mysqli_stmt_execute($stmt);

    // Liaison des résultats
    mysqli_stmt_bind_result($stmt, $id, $car_username, $car_ecurie, $temps_topic, $vitesse_topic, $energie_topic, $is_trap_inv);

    // Parcours des résultats et stockage dans l'array
    while (mysqli_stmt_fetch($stmt)) {
        $car = [
            'id' => $id,
            'car_username' => $car_username,
            'car_ecurie' => $car_ecurie,
            'temps_topic' => $temps_topic,
            'vitesse_topic' => $vitesse_topic,
            'energie_topic' => $energie_topic,
            'is_trap_inv' => $is_trap_inv
        ];
        // Ajout de la voiture à l'array
        $carsArray[] = $car;
    }

    // Fermeture du statement
    mysqli_stmt_close($stmt);
} else {
    // En cas d'erreur de préparation de la requête
    echo "Erreur de préparation de la requête : " . mysqli_error($mysqli);
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="race_assets/css/nav_race.css">
    <script src="race_assets/js/display_footer.js" defer></script>
    <script src="race_assets/js/race_js.js" defer></script>
    <title>E-Kart Race</title>
</head>

<body>
    <header>
        <button class="Btn" onclick="window.location.href = '../index.html';">
            <div class="sign">
                <svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                </svg>
            </div>
            <div class="text">Retour</div>
        </button>
    </header>
    <footer id="footer_cards">
        <?php
        // Initialisation de la position à 1
        $position = 1;
        ?>
        <?php foreach ($carsArray as $index => $car) { ?>
            <a href="car_id_<?php echo $car['id']; ?>.php" class="info_tel">
                <div class="info_tel">
                    <section> <!-- class="cardBody" id="cardBody<?php echo $index + 1; ?>"-->
                        <div> <!-- class="info2" id="cardBody<?php echo $index + 1; ?>Info"-->
                            <table class="table_info_tel">
                                <?php if ($car['is_trap_inv'] === 'boost') { ?>
                                    <tr>
                                        <!-- <td class="label trapStatus" id="cardBody<?php echo $index + 1; ?>InfoTrapStatus">Piège dans l'inventaire :</td> -->
                                        <td class="value trapStatusValue" id="cardBody<?php echo $index + 1; ?>InfoTrapStatusValue">
                                            <img src="race_assets/event_icones/Bullet_Bill.webp" alt="">
                                        </td>
                                    </tr>
                                <?php } elseif ($car['is_trap_inv'] === '1') { ?>
                                    <tr>
                                        <!-- <td class="label trapStatus" id="cardBody<?php echo $index + 1; ?>InfoTrapStatus">Piège dans l'inventaire :</td> -->
                                        <td class="value trapStatusValue" id="cardBody<?php echo $index + 1; ?>InfoTrapStatusValue"><img src="race_assets/event_icones/MKWii-TripleBanane.webp" alt=""></td>
                                    </tr>
                                <?php } elseif ($car['is_trap_inv'] === '2') { ?>
                                    <tr>
                                        <!-- <td class="label trapStatus" id="cardBody<?php echo $index + 1; ?>InfoTrapStatus">Piège dans l'inventaire :</td> -->
                                        <td class="value trapStatusValue" id="cardBody<?php echo $index + 1; ?>InfoTrapStatusValue"><img src="race_assets/event_icones/Thwomp_NSMBU.webp" alt=""></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <!-- <td class="label trapStatus" id="cardBody<?php echo $index + 1; ?>InfoTrapStatus">Piège dans l'inventaire :</td> -->
                                        <td class="value trapStatusValue" id="cardBody<?php echo $index + 1; ?>InfoTrapStatusValue"><img src="race_assets/event_icones/none.webp" alt=""></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($car['energie_topic'] >= 51) { ?>
                                    <tr>
                                        <td>
                                            <div class="barcontainer">
                                                <div class="bar" style="height:<?php echo $car['energie_topic']; ?>%; background-color: green;" data-percentage="<?php echo $car['energie_topic']; ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } elseif ($car['energie_topic'] >= 31 && $car['energie_topic'] < 51) { ?>
                                    <tr>
                                        <td>
                                            <div class="barcontainer">
                                                <div class="bar" style="height:<?php echo $car['energie_topic']; ?>%; background-color: orange;" data-percentage="<?php echo $car['energie_topic']; ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } elseif ($car['energie_topic'] >= 26 && $car['energie_topic'] < 31) { ?>
                                    <tr>
                                        <td>
                                            <div class="barcontainer">
                                                <div class="bar" style="height:1%; background-color: red;" data-percentage="<?php echo $car['energie_topic']; ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } elseif ($car['energie_topic'] <= 25) { ?>
                                    <tr>
                                        <td>
                                            <h1 style="color: red">Plus de batterie !!!!!!</h1>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </section>
                </div>
            </a>
            <div class="player<?php echo $index + 1; ?>_card card" id="player<?php echo $index + 1; ?>_card">
                <section class="cardHeader" id="cardHeader<?php echo $index + 1; ?>">
                    <div class="right" id="cardHeader<?php echo $index + 1; ?>Right">
                        <span class="whiteTitle" id="cardHeader<?php echo $index + 1; ?>WhiteTitle"><?php echo $car['car_username']; ?></span>
                        <span class="team" id="cardHeader<?php echo $index + 1; ?>Team"><?php echo $car['car_ecurie']; ?></span>
                    </div>
                    <div class="left" id="cardHeader<?php echo $index + 1; ?>Left">
                        <img src="https://philibert-gentien.digitalprojects.fr/projects/projet72h/course/race_assets/pilote_img/pilote.png" alt="Player <?php echo $index + 1; ?>" id="cardHeader<?php echo $index + 1; ?>LeftIMG">
                    </div>
                </section>
                <section class="cardBody" id="cardBody<?php echo $index + 1; ?>">
                    <div class="info" id="cardBody<?php echo $index + 1; ?>Info">
                        <table class="table">
                            <tr>
                                <td class="label currentLap" id="cardBody<?php echo $index + 1; ?>InfoCurrentLap">Temps au tour actuel :</td>
                                <td class="value currentLapValue" id="cardBody<?php echo $index + 1; ?>InfoCurrentLapValue"><?php echo ($car['temps_topic']) ?></td>
                            </tr>
                            <tr>
                                <td class="label speed" id="cardBody<?php echo $index + 1; ?>InfoSpeed">Vitesse :</td>
                                <td class="value speedValue" id="cardBody<?php echo $index + 1; ?>InfoSpeedValue"><?php echo ($car['vitesse_topic']) ?> m/s</td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
            </div>
            <?php
            // Incrémentation de la position pour la prochaine voiture
            $position++;
            ?>
        <?php } ?>
    </footer>

</html>
