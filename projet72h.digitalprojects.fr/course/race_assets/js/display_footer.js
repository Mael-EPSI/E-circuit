var btn = document.getElementById("nav_link_footer");
var footer = document.getElementById("footer_cards");

function displayHideCarsInfos() {
    if(footer.style.display == "flex") {
        footer.style.animation = "hideItem .5s ease-out forwards"; // Appliquer l'animation pour masquer
        setTimeout(function(){ footer.style.display = "none"; }, 700); // Masquer après l'animation
    } else {
        footer.style.display = "flex";
        footer.style.animation = "displayItem .5s ease-out forwards"; // Appliquer l'animation pour afficher
    }
}
