<?php
// Démarrer/créer une session
session_start();    // PREMIERE INSTRUCTION
// Récupérer la variable de session "utilisateur"
$pseudo = null;
if (isset($_SESSION["pseudo"])) {
    $pseudo= $_SESSION["pseudo"];
}


require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';
require_once BASE_PROJET."/src/fonctions.php";

$id = null;
$erreur=false;
if (isset($_GET["id"])) {
    $id = filter_var($_GET["id"],FILTER_VALIDATE_INT);
    $film = getDetails($id);
    if ($film==null) {
        $erreur=true;
    }
} else {
    $erreur=true;
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cinéma - Détails du film</title>
    <link rel="shortcut icon" href="assets/images/camera-reels.svg" />
</head>
<body class="bg-light">


<!--Insertion d'un menu-->
<?php require_once BASE_PROJET.'/src/_partials/header.php' ?>

<section class="container bg-white shadow-lg p-3 mb-5 bg-white rounded my-5">
    <?php if (!$erreur): ?>
        <div class="container">
            <h1 class="border-bottom border-primary border-3">Détails</h1>
            <div class="row align-items-center">
                <div class="col text-center">
                    <img height="305px" width="220px" class="shadow-lg p-3 m-5 rounded-2" src="<?= $film["image"] ?>" alt="Image film">
                </div>
                <div class="col shadow-lg rounded me-5">
                    <div class="text-center mb-2">
                        <p class="badge text-bg-dark text-wrap mt-2 fs-3" style="width: 20rem;"><?= $film["titre"] ?></p>
                    </div>
                    <div class="text-center mb-4">
                        <span class="me-5 fw-semibold"><i class="bi bi-hourglass-split me-2"></i><?= convertirEnHeuresMinutes($film["duree"]) ?></span>
                        <span class="me-5 fw-semibold"><i class="bi bi-calendar-check me-2"></i><?= $film["date_fr"] ?></span>
                        <span class="fw-semibold"><i class="bi bi-geo-fill me-2"></i><?= $film["pays"] ?></span>
                    </div>
                    <p><span class="me-2 fst-italic fw-semibold">Synopsis:</span><?= $film["resume"]?></p>
                    <p class="text-secondary">Film créé par : <?php $pseudo=getPseudoUtilisateur($film["id_utilisateur"]);
                        echo $pseudo['pseudo_utilisateur']?></p>

                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="m-5 text-center text-bg-danger">
            <h1>Film introuvable...</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </div>
    <?php endif; ?>
</section>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>