<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produit = $_POST['id_produit'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    $article = [
        'id_produit' => $id_produit,
        'nom' => $nom,
        'prix' => $prix,
        'quantite' => $quantite,
    ];

   
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

  
    $_SESSION['panier'][] = $article;


    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>