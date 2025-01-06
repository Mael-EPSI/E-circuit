<?php
    session_start();
    require('../../config/config.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pilote_name = $_POST['pilote'];
        $ecrurie_name = $_POST['ecurie'];
        $car_name = stripslashes($pilote_name);
        
        $verify_Query = "SELECT * FROM cars WHERE car_username = ? AND car_ecurie = ?";
        $stmt = mysqli_prepare($mysqli, $verify_Query);
        mysqli_stmt_bind_param($stmt, "ss", $car_name, $ecrurie_name);
        mysqli_stmt_execute($stmt);
        $verify_Query_Result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($verify_Query_Result) > 0) {
            // Le pseudonyme existe déjà, définir le message d'erreur dans un cookie
            session_start();
            $_SESSION['msg_add_car'] = "Ce pseudo est déjà utilisé. Veuillez choisir un autre pseudonyme.";
            header("Location: register.php");
            exit();
        }


        $car_Query = "INSERT INTO `cars`(`car_username`, `car_ecurie`) 
                      VALUES (?, ?)";
        $stmt = mysqli_prepare($mysqli, $car_Query);
        mysqli_stmt_bind_param($stmt, "ss", $car_name, $ecrurie_name);
        $car_Query_Result = mysqli_stmt_execute($stmt);
        if($car_Query_Result)  {
            session_start();
            $_SESSION['car_name'] = $car_name;
            $_SESSION['msg_add_car'] = "Votre voiture à bien été ajoutée";
            header('Location: ../../../code/esp/display_code.php');
            exit();
        }else {
            session_start();
            $_SESSION['msg_add_car'] = "Un problème est survenue, veuiller retenter";
            header('Location: register.php');
            exit();
        }
    }
    // Vérifier si une msg_add_car est présente dans la variable de session
    if (isset($_SESSION['msg_add_car'])) {
        $msg_add_car = htmlspecialchars($_SESSION['msg_add_car'], ENT_QUOTES, 'UTF-8');
        // Supprimer la msg_add_car de la variable de session pour éviter de l'afficher à nouveau après un rafraîchissement de la page
        unset($_SESSION['msg_add_car']);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/css/car_register.css">
    <title>Enregistrer sa voiture</title>
</head>
<body>
    <div class="container">
        <div class="left">
        </div>
        <div class="right">
        <form method="post">
            <div class="row">
                <label for="pilote">Nom du pilote :</label>
                <input type="text" name="pilote" id="pilote" placeholder="Mario" class="input" required >
            </div>
            
            <div class="row">
                <label for="name">Nom de l'écurie :</label>
                <input type="text" name="ecurie" id="ecurie" placeholder="Kart" class="input" required>
            </div>
            <button type="submit">Valider</button>
            <?php if (isset($msg_add_car)): ?>
                <div class="notification"><?php echo $msg_add_car; ?></div>
            <?php endif; ?>
        </form>
        </div>
    </div>
</body>
</html>