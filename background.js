let isDefaultBackground = true;

function changeBackground() {
    if (isDefaultBackground) {
        document.body.style.backgroundColor = '#ffcc00'; // Couleur 1
        document.body.style.backgroundImage = 'none'; // Supprimer l'image d'arrière-plan
    } else {
        document.body.style.backgroundImage = "url('images/arriere-plan.jpg')"; // Couleur 2 (image d'arrière-plan)
        document.body.style.backgroundSize = 'cover';
        document.body.style.backgroundPosition = 'center';
        document.body.style.backgroundRepeat = 'no-repeat';
    }
    isDefaultBackground = !isDefaultBackground; // Inverser l'état
}
