<?php
session_start();
$serveur = 'localhost'; 
$utilisateur = 'root'; 
$mot_de_passe = ''; 
$base_de_donnees = 'projet';

// Vérification si l'utilisateur est administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_produit'])) {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $image = $_POST['image'];

    $sql = "INSERT INTO produits (nom, prix, image) VALUES ('$nom', '$prix', '$image')";
    if (mysqli_query($conn, $sql)) {
        echo "Produit ajouté avec succès";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Supprimer un produit
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM produits WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Produit supprimé avec succès";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Récupérer les produits
$sql = "SELECT * FROM produits";
$result_produits = $conn->query($sql);

// Récupérer les utilisateurs
$sql = "SELECT * FROM utilisateurs";
$result_utilisateurs = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Produits</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .add-product {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Tableau de Bord Administrateur</h1>

        <h2>Ajouter un Produit</h2>
        <form method="post" class="add-product">
            <div class="form-group">
                <label for="nom">Nom du Produit</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="image">URL de l'image</label>
                <input type="text" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" name="ajouter_produit" class="btn btn-primary">Ajouter</button>
        </form>

        <h2>Liste des Produits</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_produits->num_rows > 0) {
                    while ($row = $result_produits->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                        echo '<td>' . number_format($row["prix"], 2) . ' €</td>';
                        echo '<td><img src="image/' . htmlspecialchars($row["image"]) . '" width="50" height="50" alt="' . htmlspecialchars($row["nom"]) . '"></td>';
                        echo '<td>';
                        echo '<a href="admin.php?action=supprimer&id=' . htmlspecialchars($row["id"]) . '" class="btn btn-danger btn-sm">Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">Aucun produit disponible</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <h2>Liste des Utilisateurs</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_utilisateurs->num_rows > 0) {
                    while ($row = $result_utilisateurs->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["role"]) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">Aucun utilisateur trouvé</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Fermeture de la connexion
mysqli_close($conn);
?>
