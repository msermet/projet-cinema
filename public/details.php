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
require_once BASE_PROJET.'/src/database/commentaire-db.php';
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

$commentaires = getCommentaire($id);
$moyenneNbCommentaires=getMoyenneEtNbCommentaires($id);
$nbCommentaires=$moyenneNbCommentaires["nombre_commentaires"];
$moyenne=round($moyenneNbCommentaires["moyenne"],1);
$moyenneEtoile=genererEtoiles(round($moyenneNbCommentaires["moyenne"],1));
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

<!--Details-->
<section class=" container">
    <?php if (!$erreur): ?>
        <div class="bg-white shadow-lg p-3 mb-5 rounded my-5">
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
                    <?php if ($nbCommentaires==1):?>
                        <p class="fw-semibold fs-5"><span class="me-1"><?=$moyenne?></span><span class="text-warning"><?=$moyenneEtoile?></span><span class="me-1 ms-3"><?=$nbCommentaires?></span>commentaire</p>
                    <?php elseif (!empty($commentaires)) :?>
                        <p class="fw-semibold fs-5"><span class="me-1"><?=$moyenne?></span><span class="text-warning"><?=$moyenneEtoile?></span><span class="me-1 ms-3"><?=$nbCommentaires?></span>commentaires</p>
                    <?php else :?>
                        <p class="fst-italic fs-5">Aucun commentaire pour ce film...</p>
                    <?php endif; ?>
                    <p><span class="me-2 fst-italic fw-semibold">Synopsis:</span><?= $film["resume"]?></p>
                    <p class="text-secondary">Film créé par : <?php $pseudo=getPseudoUtilisateur($film["id_utilisateur"]);
                        echo $pseudo['pseudo_utilisateur']?></p>
                </div>
            </div>
        </div>

        <!--Commentaires-->
        <section>
            <?php if (!$erreur): ?>
                <div class="bg-white shadow-lg p-3 mb-5 bg-white rounded">
                    <h1>Commentaires
                    <?php if (isset($_SESSION['pseudo'])) : ?>
                        <a class="btn btn-dark text-warning fw-semibold mb-2 float-end" href="ajout-commentaire.php?id=<?= $film["id_film"] ?>" role="button">Ajouter un commentaire</a>
                    <?php endif; ?>
                    </h1>
                    <div class="border-bottom border-primary border-3"></div>
                    <div class="pt-3">
                        <?php foreach ($commentaires as $commentaire) : ?>
                            <div class="row border-bottom border-3 pt-2">
                                <div class="col-9">
                                    <h6 class="text-primary ms-3"><?= getPseudoUtilisateur($commentaire['id_utilisateur'])['pseudo_utilisateur'] ?></h6>
                                    <p class="fs-5 fw-bold ms-3"><?= $commentaire["titre_commentaire"] ?></p>
                                    <p class="fs-6 fw-semibold text-secondary ms-3"><?= $commentaire["avis_commentaire"] ?></p>
                                </div>
                                <div class="col-3">
                                    <p class="text-secondary float-end me-3">Publié le<span class="ms-2 me-2 fw-semibold text-dark"><?=strftime('%d/%m/%Y',strtotime($commentaire["date_commentaire"]));?></span>à<span class="ms-2 fw-semibold text-dark"><?= $commentaire["heure_commentaire"]?></span></p>
                                    <p><span class="badge text-bg-dark fs-5 float-end me-4 text-warning"><?= $commentaire["note_commentaire"] ?><i class="bi bi-star-fill ms-1"></i></span></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>

    <?php else : ?>
        <div class=" text-center text-bg-danger shadow-lg rounded mt-5">
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