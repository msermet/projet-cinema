<?php
require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/commentaire-db.php';

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

<?php
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$titre = "";
$avis = "";
$note = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $titre = $_POST['titre'];
    $avis = $_POST['avis'];
    $note = $_POST['note'];

    //Validation des données
    if (empty($titre)) {
        $erreurs['titre'] = "Le titre est obligatoire";
    }
    if (empty($avis)) {
        $erreurs['avis'] = "L'avis est obligatoire";
    }
    if ($note>5 || $note<0) {
        $erreurs['note'] = "La note doit être comprise entre 0 et 5";
    }


    // Traiter les données
    if (empty($erreurs)) {
        // Traitement des données (insertion dans une base de données)
        // Rediriger l'utilisateur vers une autre page du site

        postCommentaireFilm($titre,$avis,$note,date("Y/m/d"),date("H:i:s"),$id_utilisateur,$id);

        // Rediriger l'utilisateur vers une autre page du site
        header("Location: details.php?id=$id");
        exit();
    }
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
            <h1 class="border-bottom border-3 border-primary pt-5">Votre évaluation pour <span class="fw-semibold fst-italic"><?= $film["titre"] ?></span></h1>
            <div class="w-50 mx-auto shadow my-5 p-4 bg-white rounded-5">
                <form action="" method="post" novalidate>
                    <div class="mb-3">
                        <label for="titre" class="form-label fw-semibold">Titre*</label>
                        <input type="text"
                               class="form-control <?= (isset($erreurs['titre'])) ? "border border-2 border-danger" : "" ?>"
                               id="titre" name="titre" value="<?= $titre ?>" placeholder="Saisir un titre"
                               aria-describedby="emailHelp">
                        <?php if (isset($erreurs['titre'])) : ?>
                            <p class="form-text text-danger"><?= $erreurs['titre'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="avis" class="form-label">Avis*</label>
                        <textarea
                                class="form-control <?= (isset($erreurs['avis'])) ? "border border-2 border-danger" : "" ?>"
                                id="avis"
                                name="avis"  placeholder="Saisir votre avis sur le film"
                                aria-describedby="emailHelp"></textarea>
                        <?php if (isset($erreurs['avis'])) : ?>
                            <p class="form-text text-danger"><?= $erreurs['avis'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label fw-semibold">Votre note*</label>
                        <input type="number"
                               class="form-control <?= (isset($erreurs['note'])) ? "border border-2 border-danger" : "" ?>"
                               id="note" name="note" value="<?= $note ?>" placeholder="Saisir votre note entre 0 et 5"
                               aria-describedby="emailHelp" min="0" max="5">
                        <?php if (isset($erreurs['note'])) : ?>
                            <p class="form-text text-danger"><?= $erreurs['note'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="text-center pt-2">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
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