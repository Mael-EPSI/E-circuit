<?php
session_start();
require('../php/config/config.php');

// Initialisation de l'array pour stocker les voitures
$carsArray = [];

// Récupération de l'ID de la voiture depuis la session
$id_car = 2; // Modifiez selon votre convention pour stocker l'ID dans la session

// Requête préparée pour récupérer la voiture avec l'ID spécifié
$query = "SELECT * FROM cars WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $query);

// Vérification de la préparation de la requête
if ($stmt) {
    // Liaison des paramètres et exécution de la requête
    mysqli_stmt_bind_param($stmt, "i", $id_car);
    mysqli_stmt_execute($stmt);

    // Liaison des résultats
    mysqli_stmt_bind_result($stmt, $id, $car_username, $car_ecurie, $temps_topic, $vitesse_topic, $energie_topic, $is_trap_inv);

    // Parcours des résultats et stockage dans l'array
    while (mysqli_stmt_fetch($stmt)) {
        $car = [
            'id' => $id,
            'car_username' => $car_username,
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
    <title>E-Kart Race</title>
    <?php
    // Rafraîchir la page toutes les 10 secondes
    header('refresh:3; url=car_id_2.php');
    ?>
    <style>
        @font-face {
            font-family: "Formula1-bold";
            src: url("../assets/font/Formula1-Bold-4.ttf") format("truetype");
        }
        
        * {
            font-family: "Formula1-bold", sans-serif; 
        }
        .barcontainer{
            border: 1px solid white;
            position: relative;
            margin-left: 50px;
            width: 25px;
            height: 320px;
        }
    
        .bar{
            position: absolute;
            bottom: 0;
            width: 100%;
            box-sizing: border-box;
            transform-origin: bottom;
        }
        .bar::after {
            content: attr(data-percentage) "%"; 
            position: absolute;
            bottom: 50%; /* Ajustez selon votre besoin */
            left: 50%;
            transform: translate(-50%, 50%); /* Centrer le texte */
            font-size: 14px; /* Ajustez selon votre besoin */
            color: black; /* Couleur du texte */
            background-color: rgba(255, 255, 255, 0.6);
            padding: 5px;
            border-radius: 3px;
        }
        .barcontainer::before {
            color: white;
            content: "100%";
            position: absolute;
            top: -20px; /* Ajustez selon votre besoin */
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px; /* Ajustez selon votre besoin */
        }

        .barcontainer::after {
            color: white;
            content: "0%";
            position: absolute;
            bottom: -20px; /* Ajustez selon votre besoin */
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px; /* Ajustez selon votre besoin */
        }
  
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background-color: #1D1D1D;
            margin: 0;
        }
        .info_tel {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .table_info_tel {   
            width: 100vw;
            height: 100vh;
        }
        .table_info_tel tbody {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 80%;
        }
        tr {
            flex-wrap: wrap;
            height: 50%;
            display: flex;
            align-content: center;
            justify-content: center;
        }
        td {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        td img {
            width: 70%;
        }
        .Btn {
            --black: #000000;
            --ch-black: #141414;
            --eer-black: #1b1b1b;
            --night-rider: #2e2e2e;
            --white: #ffffff;
            --af-white: #f3f3f3;
            --ch-white: #e1e1e1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            top: 5px;
            left: 5px;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: var(--af-white);
        }
        
        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sign svg {
            width: 17px;
        }
        
        .sign svg path {
            fill: var(--night-rider);
        }
        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: var(--night-rider);
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }
        /* hover effect on button width */
        .Btn:hover {
            width: 124px;
            border-radius: 5px;
            transition-duration: .3s;
        }
        
        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            /* padding-left: 20px; */
        }
        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }
        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }

    </style>
</head>

<body>
    <button class="Btn" onclick="window.location.href = 'index_image.php';">
        <div class="sign">
            <svg viewBox="0 0 512 512">
                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
            </svg>
        </div>
        <div class="text">Retour</div>
    </button>
    <div class="info_tel">
        <table class="table_info_tel">
            <?php if ($car['is_trap_inv'] === 'boost') { ?>
                <tr>
                    <td class="value trapStatusValue">
                        <img src="race_assets/event_icones/Bullet_Bill.webp" alt="">
                    </td>
                </tr>
            <?php } elseif ($car['is_trap_inv'] === '1') { ?>
                <tr>
                    <td class="value trapStatusValue"><img src="race_assets/event_icones/MKWii-TripleBanane.webp" alt=""></td>
                </tr>
            <?php } elseif ($car['is_trap_inv'] === '2') { ?>
                <tr>
                    <td class="value trapStatusValue"><img src="race_assets/event_icones/Thwomp_NSMBU.webp" alt=""></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="value trapStatusValue"><img src="race_assets/event_icones/none.webp" alt=""></td>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var plusBattDiv = document.getElementById('plusBatt');
            if (plusBattDiv) {
                var tbody = document.querySelector('tbody');
                if (tbody) {
                    tbody.style.flexDirection = 'column-reverse';
                }
            }
        });
    </script>
</body>

</html>