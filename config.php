<?php
session_start();

$serveur = 'localhost';
$utilisateur = 'root';
$mot_de_passe = '';
$base_de_donnees = 'projet';

$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}
?>
?>