document.addEventListener('DOMContentLoaded', (event) => {
    const darkModeToggle = document.querySelector("#dark-mode-checkbox");
    const header = document.querySelector(".dark-mode-header"); // Sélectionnez l'en-tête

    // Déterminez si le mode sombre doit être activé en vérifiant la classe sur l'élément body
    const darkModeOn = document.body.classList.contains("dark-mode");
    darkModeToggle.checked = darkModeOn;

    // Si le mode sombre est activé, assurez-vous que l'en-tête a également la classe
    if (darkModeOn) {
        header.classList.add("dark-mode");
    }

    darkModeToggle.addEventListener('change', function () {
        // Alternez le mode sombre sur le body
        document.body.classList.toggle("dark-mode");

        // Alternez également le mode sombre sur l'en-tête
        header.classList.toggle("dark-mode");

        // Enregistrez l'état actuel du mode sombre dans le local storage
        localStorage.setItem("darkMode", this.checked);
    });
});
