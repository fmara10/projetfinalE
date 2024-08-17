<?php
session_start();
$serveur = 'localhost'; 
$utilisateur = 'root'; 
$mot_de_passe = ''; 
$base_de_donnees = 'projet';

// Connexion à la base de données
$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Récupérer les produits
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #b0e0e6, #ffffff, #b0e0e6); /* Dégradé de bleu clair à blanc à bleu clair */
            color: #343a40; /* Couleur de texte par défaut */
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: rgba(0, 123, 255, 0.8); /* Transparence pour la barre de navigation */
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: white !important;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff !important; /* Couleur au survol */
        }
        h1 {
            color: #000; /* Couleur du titre en noir */
            margin-bottom: 40px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Ombre pour améliorer la lisibilité */
        }
        .card {
            transition: transform 0.2s;
            background-color: rgba(255, 255, 255, 0.9); /* Fond blanc avec transparence */
            border: 1px solid #dee2e6; /* Bordure de la carte */
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }
        .btn-primary {
            background-color: #007bff; /* Couleur des boutons */
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Couleur des boutons au survol */
        }
        .add-to-cart {
            background-color: #007bff; /* Couleur des boutons "Ajouter au panier" */
            border: none;
        }
        .add-to-cart:hover {
            background-color: #0056b3; /* Couleur au survol */
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: #007bff; /* Couleur du pied de page */
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .product-description {
            background-color: rgba(255, 228, 225, 0.8); /* Couleur de fond pour les descriptions des produits */
            padding: 10px; /* Ajout de padding */
            border-radius: 5px; /* Coins arrondis */
            margin-top: 10px; /* Marge au-dessus */
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">MaBoutique</a>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" alt="Accueil"> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produit.php">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/shop.png" alt="Magasine"> Produit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user-male-circle.png" alt="Compte"> Compte
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="panier.php">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png" alt="Panier"> Panier (<span id="cart-count">0</span>)
                    </a>
                </li>
                <li class="nav-item">
         
            </ul>
        </div>
    </nav>

    <h1 class="text-center">Produits</h1>

    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mt-4">';
                echo '<div class="card shadow-sm">';
                echo '<img src="image/' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["nom"]) . '">';
                echo '<div class="card-body product-description">'; // Application de la classe product-description
                echo '<h5 class="card-title">' . htmlspecialchars($row["nom"]) . '</h5>'; // Nom du produit
                echo '<p class="card-text">Prix: ' . number_format($row["prix"], 2) . ' €</p>'; // Prix du produit
                echo '<button class="btn add-to-cart" data-id="' . htmlspecialchars($row["id"]) . '" data-nom="' . htmlspecialchars($row["nom"]) . '" data-prix="' . htmlspecialchars($row["prix"]) . '" data-image="' . htmlspecialchars($row["image"]) . '">Ajouter au panier</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info">Aucun produit disponible</div>';
        }
        ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 MaBoutique. Tous droits réservés.</p>
    </footer>
</div>

<script>
    let cartCount = 0;

    $(document).on('click', '.add-to-cart', function() {
        const produitId = $(this).data('id');
        const nom = $(this).data('nom');
        const prix = $(this).data('prix');
        const image = $(this).data('image');

        $.post('panier.php', {
            action: 'ajouter',
            produit_id: produitId,
            nom: nom,
            prix: prix,
            image: image
        }, function(response) {
            // Mise à jour du compteur
            cartCount++;
            $('#cart-count').text(cartCount);
            alert('Produit ajouté au panier !');
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
