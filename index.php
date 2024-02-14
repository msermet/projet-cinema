
<?php
// Récupérer la liste des étudiants dans la table film

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare("SELECT * FROM film");

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
<body>
<!--    Barre de navigation-->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand text-success fs-3" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-spotify me-2" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.669 11.538a.5.5 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686m.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858m.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288"/>
                </svg>Spotify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="#">A propos des abonnements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="#">Avis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="#">Contact</a>
                    </li>
                </ul>
                <button class="btn btn-success" type="submit">Abonnez vous</button>
            </div>
        </div>
    </nav>
</header>
<!-- cartes-->
<section>
    <div class="container">
        <div class="row">
            <?php foreach ($films as $film) : ?>
                <div class="col-sm-3">
                    <div class="card border-dark mb-5 text-center" style="width: 18rem;">
                        <div class="card-body">
                            <img src="<?= $film["image"] ?>" alt="">
                            <p class="mt-3"><?= $film["titre"] ?></p>
                            <p><?= $film["duree"]?> minutes</p>
                            <button class="btn btn-warning">Détails du film</button>
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