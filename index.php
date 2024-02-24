<?php
// Récupérer la liste des étudiants dans la table film

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare("SELECT titre,(SEC_TO_TIME(duree*60)) AS duree_heure,resume,date_sortie,pays,image FROM film");

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
<body class="bg-secondary">

<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>

<!-- cartes-->
<section>
    <div class="container text-center">
        <div class="row align-items-center vh-100">
            <?php foreach ($films as $film) : ?>
                <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border-dark mb-5 text-center border-3 container" style="width: 18rem;">
                        <div class="card-body">
                            <img src="<?= $film["image"] ?>" alt="">
                            <p class="mt-3 fw-bold fs-6"><?= $film["titre"] ?></p>
                            <p class="fw-semibold">Durée : <?= $film["duree_heure"]?></p>
                            <a class="btn btn-warning fw-semibold" href="details.php?titre=<?= $film["titre"] ?>" role="button">Détails</a>
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