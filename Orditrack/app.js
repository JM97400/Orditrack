// Fonction pour afficher la section de connexion
function showLoginSection() {
    document.getElementById("loginSection").classList.remove("hidden");
}

// Fonction pour valider les informations de connexion
function handleLogin(event) {
    event.preventDefault(); // Empêcher le rechargement de la page

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Validation de l'utilisateur (simulé pour l'exemple)
    if (username === "admin" && password === "password") {
        // Masquer la section de connexion
        document.getElementById("loginSection").classList.add("hidden");
        // Afficher la section de réservation
        document.getElementById("reservationSection").classList.remove("hidden");
    } else {
        alert("Identifiants incorrects");
    }
}

// Ajouter un écouteur d'événement pour le clic sur le bouton "Réserver un PC"
document.getElementById("reserverBtn").addEventListener("click", showLoginSection);

// Ajouter un écouteur d'événement pour le clic sur le bouton "Accès Admin"
document.getElementById("adminBtn").addEventListener("click", showLoginSection);

// Ajouter un écouteur pour la soumission du formulaire de connexion
document.getElementById("loginForm").addEventListener("submit", handleLogin);
