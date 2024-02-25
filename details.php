<?php
// Récupérer la liste des étudiants dans la table film

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare("SELECT titre,(SEC_TO_TIME(duree*60)) AS duree_heure,resume,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_fr,pays,image FROM film");

// 3. Exécution de la requête
$requete->execute();

// 4. Récupération des enregistrements
// 1 enregistrement = 1 tableau associatif
$films = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$titre = null;
if (isset($_GET["titre"])) {
    $titre = $_GET["titre"];
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
    <title>Détails du film</title>
    <link rel="shortcut icon" href="assets/images/icon-film.png" />
</head>
<body class="bg-secondary">

<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>

<div class="container">
    <?php if ($titre): ?>
        <?php foreach ($films as $film) : ?>
            <?php if ($film["titre"]==$titre): ?>
                <div class="text-center">
                    <h1 class="badge text-bg-dark text-wrap text-center m-5 fs-1" style="width: 50rem;"><?= $titre ?></h1>
                </div>
                <table class="table table-warning table-striped table-bordered border-black text-center border-4">
                    <thead class="table-secondary border-black border-2">
                        <tr>
                            <th>Image</th>
                            <th>Durée</th>
                            <th>Résumé</th>
                            <th>Date de sortie</th>
                            <th>Pays</th>
                        </tr>
                    </thead>
                    <tbody class="border-black border-2">
                            <tr>
                                <td><img src="<?= $film["image"] ?>" alt=""></td>
                                <td><?= $film["duree_heure"] ?></td>
                                <td><?= $film["resume"]?></td>
                                <td><?= $film["date_fr"] ?></td>
                                <td><?= $film["pays"] ?></td>
                            </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="m-5 text-center text-bg-danger">
            <h1>Le paramètre titre est obligatoire.</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </div>
    <?php endif; ?>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>