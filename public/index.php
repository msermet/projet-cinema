<?php
// Démarrer/créer une session
session_start();    // PREMIERE INSTRUCTION
// Récupérer la variable de session "utilisateur"
$pseudo = null;
if (isset($_SESSION["pseudo"])) {
    $pseudo= $_SESSION["pseudo"];
}

require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
$films = getFilmsACcueil();

require_once BASE_PROJET."/src/fonctions.php";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        section {
            padding: 60px 0;
        }
    </style>
    <title>Cinéma - Accueil</title>
    <link rel="shortcut icon" href="assets/images/camera-reels.svg" />
</head>
<body>

<!--Insertion d'un menu-->
<?php require_once BASE_PROJET.'/src/_partials/header.php' ?>

<?php if (isset($_SESSION['pseudo'])) : ?>
    <p class="fw-bold pt-5 me-5 fs-5 text-end">Heureux de vous revoir <span class="text-primary"><?= $pseudo ?></span> !</p>
<?php endif; ?>

<div class="container">
    <h1 class="border-bottom border-primary border-3 fw-semibold text-dark pt-5">Accueil</h1>
    <p class="ms-2 fw-semibold fs-5">Découvrez notre présentation de divers films avec leurs détails, et plus encore comme l'ajout de vos films préférés !</p>
</div>
<div class="border-top border-3"></div>

<!-- cartes-->
<section class=bg-light">
    <div class="text-center">
        <p class="badge text-bg-dark text-wrap fs-2" style="width: 20rem;">Nouveautés :</p>
    </div>
    <div class="container text-center pt-5">
        <div class="row align-items-center">
            <?php foreach ($films as $film) : ?>
                <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3 mb-5">
                    <div class="card border-dark text-center border-2 container bg-white shadow" style="width: 18rem;">
                        <div class="card-body">
                            <img height="305px" width="220px" class="rounded-2" src="<?= $film["image"] ?>" alt="">
                            <p class="mt-3 fw-bold fs-6"><?= $film["titre"] ?></p>
                            <p class="fw-semibold">Durée : <?= convertirEnHeuresMinutes($film["duree"])?></p>
                            <a class="btn btn-primary fw-semibold" href="details.php?id=<?= $film["id_film"] ?>" role="button">Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-center pt-5">
        <a class="btn btn-secondary fs-4 fw-bold" href="liste-des-films.php" role="button">Voir les autres films</a>
    </div>
</section>

<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">&copy; 2024 Cinéma</p>

        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item me-3">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" href="/public/liste-des-films.php" role="button">Liste des films</a>
            </li>
            <li class="nav-item me-3">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" role="button" href="/public/ajouter-film.php">Ajouter un film</a>
            </li>
            <li class="nav-item me-3">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" role="button" href="/public/connexion.php">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" role="button" href="/public/creation-de-compte.php">Inscription</a>
            </li>
        </ul>
    </footer>
</div>



<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>


