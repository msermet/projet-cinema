<?php
// Récupérer la liste des étudiants dans la table film

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare("SELECT * FROM film");

// 3. Exécution de la requête
$requete->execute();

// 4. Récupération des enregistrements
// 1 enregistrement = 1 tableau associatif
$films = $requete->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        section {
            padding: 60px 0;
        }
    </style>
    <title>Films</title>
    <link rel="shortcut icon" href="./assets/images/icon-film.png" />
</head>
<body>
<!--    Barre de navigation-->
<header>
    <nav class="navbar navbar-expand-lg bg-warning navbar-expand-md">
        <div class="container-fluid">
            <h1 class="navbar-brand text-dark fs-3" href="#"><i class="bi bi-film me-2"></i>Films</h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active fs-5 fw-semibold" aria-current="page" href="#">Nouveau film</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5 fw-semibold" aria-current="page" href="#">Cinémathèque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5 fw-semibold" aria-current="page" href="#">Les mieux notés</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-outline-dark fw-bold border-2">En savoir plus</button>
            </div>
        </div>
    </nav>
</header>
<!-- cartes-->
<section>
    <div class="container">
        <div class="row">
            <?php foreach ($films as $film) : ?>
                <div class="col-sm-3">
                    <div class="card border-dark mb-5 text-center border-2" style="width: 18rem;">
                        <div class="card-body">
                            <img src="<?= $film["image"] ?>" alt="">
                            <p class="mt-3 fw-semibold fs-5"><?= $film["titre"] ?></p>
                            <p class="fw-bold"><?= $film["duree"]?> minutes</p>
                            <button class="btn btn-warning">Détails du film</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>