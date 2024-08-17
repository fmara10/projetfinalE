<?php
// Paramètres de connexion à la base de données
$serveur = 'localhost';
$utilisateur = 'root';
$mot_de_passe = '';
$base_de_donnees = 'nom_de_votre_base_de_donnees'; // Remplacez par le nom de votre base de données

// Connexion à la base de données
$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérification de la connexion
if (!$connexion) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête SQL pour vérifier les informations d'identification
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
    $resultat = mysqli_query($connexion, $sql);

    // Vérification s'il y a une correspondance d'utilisateur
    if (mysqli_num_rows($resultat) == 1) {
        // Utilisateur trouvé, rediriger vers une page produit par exemple
        header("Location: produits.php");
        exit();
    } else {
        // Aucun utilisateur correspondant, afficher un message d'erreur
        echo "Email ou mot de passe incorrect.";
    }
}

// Fermer la connexion à la base de données
mysqli_close($connexion);
?>