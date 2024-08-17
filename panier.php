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

// Traitement des actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $produit_id = $_POST['produit_id'] ?? '';

    if ($action == "ajouter") {
        $nom = $_POST["nom"] ?? '';
        $prix = $_POST["prix"] ?? 0.0;
        $image = $_POST["image"] ?? '';
        
        // Vérifiez si le produit est déjà dans le panier
        $check_sql = "SELECT * FROM panier WHERE produit_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("i", $produit_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Mettre à jour la quantité si le produit est déjà dans le panier
            $update_sql = "UPDATE panier SET quantite = quantite + 1 WHERE produit_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("i", $produit_id);
        } else {
            // Insérer un nouveau produit dans le panier
            $insert_sql = "INSERT INTO panier (produit_id, nom, prix, image, quantite) VALUES (?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("isss", $produit_id, $nom, $prix, $image);
        }

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }
        $stmt->close();
        exit(); // Terminer le script après traitement AJAX
    } elseif ($action == "diminuer") {
        // Diminuer la quantité du produit
        $update_sql = "UPDATE panier SET quantite = quantite - 1 WHERE produit_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $produit_id);
        $stmt->execute();

        // Supprimer le produit du panier si la quantité est nulle ou inférieure à zéro
        $delete_sql = "DELETE FROM panier WHERE quantite <= 0";
        $conn->query($delete_sql);
        $stmt->close();
        header("Location: panier.php"); // Rediriger pour rafraîchir la page
        exit();
    } elseif ($action == "supprimer") {
        // Supprimer le produit du panier
        $delete_sql = "DELETE FROM panier WHERE produit_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $produit_id);
        $stmt->execute();
        $stmt->close();
        header("Location: panier.php"); // Rediriger pour rafraîchir la page
        exit();
    } elseif ($action == "augmenter") {
        // Augmenter la quantité du produit
        $update_sql = "UPDATE panier SET quantite = quantite + 1 WHERE produit_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $produit_id);
        $stmt->execute();
        $stmt->close();
        header("Location: panier.php"); // Rediriger pour rafraîchir la page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; /* Couleur bleu clair pour l'arrière-plan */
        }
        
        .btn-action {
            width: 50px; /* Largeur uniforme pour tous les boutons */
            height: 50px; /* Hauteur uniforme pour tous les boutons */
            font-size: 20px; /* Taille du texte */
            border: none; /* Pas de bordure */
            margin: 5px; /* Espacement autour des boutons */
        }

        .btn-augmenter {
            background-color: #90ee90; /* Couleur vert clair pour augmenter */
        }
        
        .btn-augmenter:hover {
            background-color: #76c76a; /* Couleur au survol pour augmenter */
        }

        .btn-diminuer {
            background-color: #ffb6c1; /* Couleur rose clair pour diminuer */
        }
        
        .btn-diminuer:hover {
            background-color: #f8a3b3; /* Couleur au survol pour diminuer */
        }

        .btn-supprimer {
            background-color: #ff6347; /* Couleur rouge pour supprimer */
        }
        
        .btn-supprimer:hover {
            background-color: #ff4d39; /* Couleur au survol pour supprimer */
        }

        .product-info {
            background-color: #E6E6FA; /* Couleur violet clair pour le fond des informations produit */
            padding: 10px; /* Ajout d'un peu de remplissage */
            border-radius: 5px; /* Coins arrondis */
        }

        .logout-icon {
            margin-top: 5px; /* Ajustez cette valeur selon vos besoins */
            width: 40px; /* Ajustez la largeur ici */
            height: 40px; /* Ajustez la hauteur ici */
        }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Vente de Volaille</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
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
                    <a class="nav-link" href="deconnexion.php">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/logout-rounded-left.png" alt="Déconnexion"> Déconnexion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mt-5 text-center">Panier</h1>

    <div class="row justify-content-center">
        <?php
        // Afficher les produits dans le panier
        $sql = "SELECT * FROM panier";
        $result = $conn->query($sql);

        $total = 0.0; // Initialiser le total

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Ne pas afficher le produit si l'image est vide
                if (empty($row["image"])) {
                    continue; // Passer à l'itération suivante
                }

                echo '<div class="col-md-4 mt-4">';
                echo '<div class="card">';
                echo '<img src="image/' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["nom"]) . '">';
                echo '<div class="card-body product-info">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["nom"]) . '</h5>';
                echo '<p class="card-text">Prix: ' . number_format($row["prix"], 2) . ' €</p>';
                echo '<p class="card-text">Quantité: ' . htmlspecialchars($row["quantite"]) . '</p>';

                // Calculer le total
                $total += $row["prix"] * $row["quantite"];

                // Formulaires pour les actions
                echo '<form method="post" action="panier.php" class="d-inline">';
                echo '<input type="hidden" name="produit_id" value="' . htmlspecialchars($row["produit_id"]) . '">';
                echo '<input type="hidden" name="action" value="augmenter">';
                echo '<button type="submit" class="btn-action btn-augmenter">+</button>';
                echo '</form>';

                echo '<form method="post" action="panier.php" class="d-inline">';
                echo '<input type="hidden" name="produit_id" value="' . htmlspecialchars($row["produit_id"]) . '">';
                echo '<input type="hidden" name="action" value="diminuer">';
                echo '<button type="submit" class="btn-action btn-diminuer">-</button>';
                echo '</form>';

                echo '<form method="post" action="panier.php" class="d-inline">';
                echo '<input type="hidden" name="produit_id" value="' . htmlspecialchars($row["produit_id"]) . '">';
                echo '<input type="hidden" name="action" value="supprimer">';
                echo '<button type="submit" class="btn-action btn-supprimer">Sup</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info">Panier vide</div>';
        }
        ?>
    </div>

    <h2 class="mt-5 text-center">Total à payer : <?php echo number_format($total, 2); ?> €</h2>

    <!-- Conteneur pour le bouton PayPal -->
    <div id="paypal-button-container" class="text-center mt-5"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AfVi9k_IjOcI16Xyppm5pznxqq0vEkvwA5eQLA3Ertynq-GisajRBDU1y3OC2EyvV8p2KwUTqfJZ1c-E"></script>

<script>
    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo number_format($total, 2); ?>'
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert('Transaction complétée par ' + details.payer.name.given_name + '!');
                // Optionnel: redirigez vers une page de confirmation ici
            });
        },
        onError: function(err){
            console.log("erreur dans le paiement", err);
            alert("paiement échoué");
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>
