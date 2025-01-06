const slider = document.querySelector(".slider");
let lastActivationTime = 0;
const cooldownDuration = 500; // Durée du cooldown en millisecondes (ici 1 seconde)

function activate(e) {
  const currentTime = Date.now();
  // Vérifier si le cooldown est écoulé
  if (currentTime - lastActivationTime < cooldownDuration) {
    return; // Ne rien faire si le cooldown n'est pas écoulé
  }
  lastActivationTime = currentTime; // Mettre à jour le temps de la dernière activation
  
  const items = document.querySelectorAll(".item");
  e.target.matches(".next") && slider.append(items[0]);
  e.target.matches(".prev") && slider.prepend(items[items.length - 1]);
}

document.addEventListener("keydown", (e) => {
  if (e.key === "ArrowRight") {
    document.querySelector(".next").click();
  } else if (e.key === "ArrowLeft") {
    document.querySelector(".prev").click();
  }
});

document.addEventListener("click", activate, false);
