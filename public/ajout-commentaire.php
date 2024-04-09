<?php
require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';

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

require_once BASE_PROJET.'/src/database/film-db.php';
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

require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';
require_once BASE_PROJET."/src/fonctions.php";
?>

<?php
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$titre = "";
$resume = "";
$duree = "";
$date = "";
$pays = "";
$image = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $titre = $_POST['titre'];

    //Validation des données
    if (empty($titre)) {
        $erreurs['titre'] = "Le titre est obligatoire";
    }


    // Traiter les données
    if (empty($erreurs)) {
        // Traitement des données (insertion dans une base de données)
        // Rediriger l'utilisateur vers une autre page du site

        //postFilm($titre);

        // Rediriger l'utilisateur vers une autre page du site
        header("Location: ../index.php");
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
                <label for="exampleFormControlTextarea1" class="form-label fw-semibold">Avis*</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Saisir votre avis"></textarea>
            </div>
            <div class="mb-3">
                <label for="duree" class="form-label fw-semibold">Votre note*</label>
                <input type="number"
                       class="form-control <?= (isset($erreurs['duree'])) ? "border border-2 border-danger" : "" ?>"
                       id="duree" name="duree" value="<?= $duree ?>" placeholder="Saisir votre note entre 0 et 5"
                       aria-describedby="emailHelp" min="0" max="5">
            </div>
            <div class="text-center pt-2">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>