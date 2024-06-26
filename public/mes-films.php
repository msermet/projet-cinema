<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';
$films = getFilmsListe();

require_once BASE_PROJET."/src/fonctions.php";

session_start();
if (empty($_SESSION)) {
    header("Location: ../index.php");
}

$pseudo = null;
if (isset($_SESSION["pseudo"])) {
    $pseudo= $_SESSION["pseudo"];
}

$email_utilisateur = null;
if (isset($_SESSION["email_utilisateur"])) {
    $email_utilisateur= $_SESSION["email_utilisateur"];
}

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
    <title>Cinéma - Mes films</title>
    <link rel="shortcut icon" href="assets/images/camera-reels.svg" />
</head>
<body class="bg-light">

<!--Insertion d'un menu-->
<?php require_once BASE_PROJET.'/src/_partials/header.php' ?>

<div class="container">
    <h1 class="border-bottom border-primary border-3 mt-5 m-2 fw-semibold text-dark">Mes films</h1>
</div>
<!-- cartes-->
<section>
    <div class="container text-center">
        <div class="row align-items-center">
            <?php $id = getIdUtilisateur($email_utilisateur); ?>
            <?php $filmExiste=0; ?>
            <?php foreach ($films as $film) : ?>
                <?php if ($id['id_utilisateur']==$film["id_utilisateur"]) : ?>
                    <?php $filmExiste=1; ?>
                    <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">
                        <div class="card border-dark mb-5 text-center border-2 container bg-white shadow" style="width: 18rem;">
                            <div class="card-body">
                                <img height="305px" width="220px" class="rounded-2" src="<?= $film["image"] ?>" alt="">
                                <p class="mt-3 fw-bold fs-6"><?= $film["titre"] ?></p>
                                <p class="fw-semibold">Durée : <?= convertirEnHeuresMinutes($film["duree"])?></p>
                                <a class="btn btn-primary fw-semibold" href="details.php?id=<?= $film["id_film"] ?>" role="button">Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($filmExiste==0) : ?>
            <p class="fs-3 fst-italic">Vous n'avez pas créé de film...</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- images : placeholder-->