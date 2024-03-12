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
    $resume = $_POST['resume'];
    $duree = $_POST['duree'];
    $date = $_POST['date'];
    $pays = $_POST['pays'];
    $image = $_POST['image'];

    //Validation des données
    if (empty($titre)) {
        $erreurs['titre'] = "Le titre est obligatoire";
    }
    if (empty($resume)) {
        $erreurs['resume'] = "Le résumé est obligatoire";
    }
    if (empty($duree)) {
        $erreurs['duree'] = "La durée est obligatoire";
    } elseif ($duree<0) {
        $erreurs['duree'] = "La durée n'est pas valide";
    }
    if (empty($date)) {
        $erreurs['date'] = "La date est obligatoire";
    }
    if (empty($pays)) {
        $erreurs['pays'] = "Le pays est obligatoire";
    }
    if (empty($image)) {
        $erreurs['image'] = "Le lien de l'image est obligatoire";
    } elseif (!filter_var($image,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED)) {
        $erreurs['image'] = "Le lien de l'image n'est pas valide";
    }

    // Traiter les données
    if (empty($erreurs)) {
        // Traitement des données (insertion dans une base de données)
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
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gluten:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Formulaire</title>
</head>
<body>
<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>
<div class="container">
    <h1>Formulaire</h1>
    <div class="w-50 mx-auto shadow my-5 p-4 bg-white rounded-5">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="titre" class="form-label">Titre*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['titre'])) ? "border border-2 border-danger" : "" ?>"
                       id="titre" name="titre" value="<?= $titre ?>" placeholder="Saisir le titre"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['titre'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['titre'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Résumé*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['resume'])) ? "border border-2 border-danger" : "" ?>"
                       id="resume"
                       name="resume" value="<?= $resume ?>" placeholder="Saisir le résumé"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['resume'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['resume'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="duree" class="form-label">Durée*</label>
                <input type="number"
                       class="form-control <?= (isset($erreurs['duree'])) ? "border border-2 border-danger" : "" ?>"
                       id="duree" name="duree" value="<?= $duree ?>" placeholder="Saisir la durée"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['duree'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['duree'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date*</label>
                <input type="date"
                       class="form-control <?= (isset($erreurs['date'])) ? "border border-2 border-danger" : "" ?>"
                       id="date" name="date" value="<?= $date ?>" placeholder="Saisir la date de sortie"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['date'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['date'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="pays" class="form-label">Pays*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['pays'])) ? "border border-2 border-danger" : "" ?>"
                       id="pays" name="pays" value="<?= $pays ?>" placeholder="Saisir le pays"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['pays'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['pays'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image*</label>
                <input type="url"
                       class="form-control <?= (isset($erreurs['image'])) ? "border border-2 border-danger" : "" ?>"
                       id="image" name="image" value="<?= $image ?>" placeholder="Saisir le lien de l'image"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['image'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['image'] ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
</div>


<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>