<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Buy Product Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Simulate fetching product details from a database
    $product = [
        'name' => 'ienManger.com propose une variété de viandes de poulet, notamment des filets, des cuisses, des ailes et des poulets entiers élevés en plein air en Lozère.',
        'discount' => 'Rabais ajouté au panier',
        'image' => 'poulette.png',
        'features' => [
            'poules: rouge,blanc,noir',
            
        ]
    ];
    ?>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Best_Buy_Logo.svg/1200px-Best_Buy_Logo.svg.png" width="100" alt="Best Buy">
            </a>
            <form class="form-inline my-2 my-lg-0 ml-auto">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher Best Buy" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </nav>
        
        <div class="breadcrumb mt-4">
            <a href="#">Accueil</a> &gt; 
            <a href="#">Ordinateurs et tablettes</a> &gt; 
            <a href="#">Portables et MacBook</a> &gt; 
            <a href="#">Portables Windows</a> &gt; 
            Détails sur le produit
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2><?php echo $product['name']; ?></h2>
                <p class="text-danger"><?php echo $product['price']; ?></p>
                <p class="text-success"><?php echo $product['discount']; ?></p>
                <button class="btn btn-primary">Ajouter au panier</button>
                <p class="mt-2"><a href="#">cliquez pour voir vos produits</a></p>
                <p><a href="#">Magasinez les aubaines Entrepôt à partir de 1 499,99 $</a></p>
                <div class="mt-4">
                    <h5>Caractéristiques</h5>
                    <ul>
                        <?php foreach ($product['features'] as $feature) : ?>
                            <li><?php echo $feature; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>