<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Panier</h1>
    
    <?php
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $produit_id = $_POST["produit_id"];
        $nom = $_POST["nom"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];
        $image = $_POST["image"];
        $categorie = $_POST["categorie"];

        if ($action == "ajouter") {
            // Vérifier si le produit est déjà dans le panier
            $check_sql = "SELECT quantite FROM panier WHERE produit_id = ?";
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
                $insert_sql = "INSERT INTO panier (produit_id, nom, description, prix, image, categorie, quantite) VALUES (?, ?, ?, ?, ?, ?, 1)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("issdss", $produit_id, $nom, $description, $prix, $image, $categorie);
            }

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Produit ajouté au panier avec succès</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $stmt->error . '</div>';
            }
        } elseif ($action == "diminuer") {
            // Diminuer la quantité du produit dans le panier
            $update_sql = "UPDATE panier SET quantite = quantite - 1 WHERE produit_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("i", $produit_id);
            $stmt->execute();

            // Supprimer le produit du panier si la quantité est nulle ou inférieure à zéro
            $delete_sql = "DELETE FROM panier WHERE quantite <= 0";
            $conn->query($delete_sql);

            if ($stmt->execute()) {
                echo '<div class="alert alert-warning" role="alert">Quantité diminuée</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $stmt->error . '</div>';
            }
        } elseif ($action == "supprimer") {
            // Supprimer le produit du panier
            $delete_sql = "DELETE FROM panier WHERE produit_id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $produit_id);

            if ($stmt->execute()) {
                echo '<div class="alert alert-danger" role="alert">Produit supprimé du panier</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $stmt->error . '</div>';
            }
        } elseif ($action == "mettre_a_jour") {
            // Réinitialiser la quantité à zéro
            $update_sql = "UPDATE panier SET quantite = 0 WHERE produit_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("i", $produit_id);
            $stmt->execute();

            // Supprimer le produit du panier si la quantité est nulle
            $delete_sql = "DELETE FROM panier WHERE quantite <= 0";
            $conn->query($delete_sql);

            if ($stmt->execute()) {
                echo '<div class="alert alert-info" role="alert">Quantité réinitialisée</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $stmt->error . '</div>';
            }
        }

        $stmt->close();
    }

    // Afficher les produits du panier
    $sql = "SELECT * FROM panier";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mt-4">';
            echo '<div class="card">';
            echo '<img src="' . $row["image"] . '" class="card-img-top" alt="' . $row["nom"] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row["nom"] . '</h5>';
            echo '<p class="card-text">' . $row["description"] . '</p>';
            echo '<p class="card-text">Prix: $' . $row["prix"] . '</p>';
            echo '<p class="card-text">Quantité: ' . $row["quantite"] . '</p>';

            // Formulaires pour les actions
            echo '<form method="post" action="panier.php" class="d-inline">';
            echo '<input type="hidden" name="produit_id" value="' . $row["produit_id"] . '">';
            echo '<input type="hidden" name="nom" value="' . $row["nom"] . '">';
            echo '<input type="hidden" name="description" value="' . $row["description"] . '">';
            echo '<input type="hidden" name="prix" value="' . $row["prix"] . '">';
            echo '<input type="hidden" name="image" value="' . $row["image"] . '">';
            echo '<input type="hidden" name="categorie" value="' . $row["categorie"] . '">';
            echo '<input type="hidden" name="action" value="diminuer">';
            echo '<button type="submit" class="btn btn-warning">Diminuer</button>';
            echo '</form>';

            echo '<form method="post" action="panier.php" class="d-inline">';
            echo '<input type="hidden" name="produit_id" value="' . $row["produit_id"] . '">';
            echo '<input type="hidden" name="action" value="supprimer">';
            echo '<button type="submit" class="btn btn-danger">Supprimer</button>';
            echo '</form>';

            echo '<form method="post" action="panier.php" class="d-inline">';
            echo '<input type="hidden" name="produit_id" value="' . $row["produit_id"] . '">';
            echo '<input type="hidden" name="action" value="mettre_a_jour">';
            echo '<button type="submit" class="btn btn-info">Réinitialiser</button>';
            echo '</form>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "Panier vide";
    }

    $conn->close();
    ?>
</div>
</body>
</html>