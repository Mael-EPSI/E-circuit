<?php
function create_nav_button($action, $text, $has_icon = false) {
    echo "<li class='nav_link' ><a onclick=\"$action\">";
    if ($has_icon) {
        echo "<div class=\"red_point\"></div>";
    }
    echo "$text</a></li>";
}
?>

<nav class="nav navbar">
    <ul>
        <?php
        // Inclure le fichier nav_btn.php pour accéder à la fonction create_nav_button
        include 'nav_btn.php';

        // Appeler la fonction pour créer les boutons de navigation
        create_nav_button("change_video()", "Direct", true); // Premier bouton avec icône
        create_nav_button("displayHideCarsInfos()", "Information"); // Deuxième bouton sans icône
        ?>
    </ul>
</nav>
