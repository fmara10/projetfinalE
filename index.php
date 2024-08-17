<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gildas Élevage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-background video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content {
            position: relative;
            text-align: center;
            z-index: 1;
            color: #fff;
            padding: 50px;
        }

        .btn-start {
            background-color: #ffc107;
            color: #343a40;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-start:hover {
            background-color: #ffca2c;
        }

        
        .product-section {
            padding: 50px 0;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .product-price {
            font-size: 2em;
            color: #dc3545;
        }

        .product-discount {
            color: #28a745;
        }

        .navbar {
            background-color: orange; 
        }
    </style>
</head>
<body>

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

<div class="video-background">
    <video autoplay muted loop>
        <source src="video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<div class="content">
    <h1>Bienvenue à Gildas Élevage</h1>
    <button class="btn btn-start" onclick="window.location.href='connexion.php'">Démarrer</button>
</div>



<div class="container product-section">
    <div class="breadcrumb mt-4">
        
    propose une variété de viandes de poulet, notamment des filets, des cuisses, des ailes et des poulets entiers élevés en plein air en Lozère  Vous pouvez commander ces produits frais et les faire livrer 
    </div>

   
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    
    $(document).ready(function() {
        $(".navbar-nav a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    window.location.hash = hash;
                });
            }
        });
    });
</script>

</body>
</html>