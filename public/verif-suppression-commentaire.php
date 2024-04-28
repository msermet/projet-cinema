<?php
require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';
require_once BASE_PROJET.'/src/database/commentaire-db.php';
require_once BASE_PROJET."/src/fonctions.php";

session_start();
if (empty($_SESSION)) {
    header("Location: ../index.php");
}

$pseudo = null;
if (isset($_SESSION["pseudo"])) {
    $pseudo= $_SESSION["pseudo"];
}
$id_utilisateur = null;
if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur= $_SESSION['id_utilisateur'];
}

$existeCommentaire = null;
if (isset($_SESSION['existeCommentaire'])) {
    $existeCommentaire= $_SESSION['existeCommentaire'];
}

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

if ($id) {
    $commentaires = getCommentaire($id);
}

if (empty($_SESSION["existeCommentaire"])) {
    header("Location: ../index.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gluten:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cinéma - Ajouter un film</title>
    <link rel="shortcut icon" href="assets/images/camera-reels.svg" />
</head>
<body class="bg-light">
<!--Insertion d'un menu-->
<?php require_once BASE_PROJET.'/src/_partials/header.php' ?>
<div class="container">
    <?php if (!$erreur): ?>
        <div class="container">
            <h1 class="border-bottom border-3 border-primary pt-5">Suppression de votre commentaire pour le film <span class="fst-italic"><?= $film['titre'] ?></span></h1>
            <div class="w-75 mx-auto shadow my-5 p-4 bg-white rounded-5">
                <form action="" method="post" novalidate>

                    <div class="pt-3">
                        <?php foreach ($commentaires as $commentaire): ?>
                            <?php if ($id_utilisateur == $commentaire['id_utilisateur']) : ?>
                                <div class="row border-bottom border-top border-3 pt-2 mb-4">
                                    <div class="col-8">
                                        <h6 class="text-primary ms-3"><?= getPseudoUtilisateur($commentaire['id_utilisateur'])['pseudo_utilisateur'] ?></h6>
                                        <p class="fs-5 fw-bold ms-3"><?= $commentaire["titre_commentaire"] ?></p>
                                        <p class="fs-6 fw-semibold text-secondary ms-3"><?= $commentaire["avis_commentaire"] ?></p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary float-end me-3">Publié le<span class="ms-2 me-2 fw-semibold text-dark"><?=strftime('%d/%m/%Y',strtotime($commentaire["date_commentaire"]));?></span>à<span class="ms-2 fw-semibold text-dark"><?= $commentaire["heure_commentaire"]?></span></p>
                                        <p><span class="badge text-bg-dark fs-5 float-end me-4 text-warning"><?= $commentaire["note_commentaire"] ?><i class="bi bi-star-fill ms-1"></i></span></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-center pt-2">
                        <a class="btn btn-primary" href="suppression-commentaire.php?id=<?= $film["id_film"] ?>" role="button">Supprimer</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else : ?>
        <div class=" text-center text-bg-danger shadow-lg rounded mt-5">
            <h1>Film introuvable...</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </div>
    <?php endif; ?>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>