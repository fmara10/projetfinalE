<?php
require 'config.php';

// Vérifiez si l'utilisateur connecté est un utilisateur standard
if ($_SESSION['role'] !== 'user') {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Bienvenue sur le tableau de bord Utilisateur</h1>
        <p>Vous êtes connecté en tant qu'utilisateur.</p>
        <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
    </div>
</body>
</html>