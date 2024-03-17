<?php
// Récupérer la liste des étudiants dans la table etudiant

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';
?>

<?php
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$pseudo = "";
$email_utilisateur = "";
$mdp = "";
$mdp_confirmation = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $pseudo = $_POST['pseudo'];
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp = $_POST['mdp'];
    $mdp_confirmation = $_POST['mdp_confirmation'];

    //Validation des données
    if (empty($pseudo)) {
        $erreurs['pseudo'] = "Le pseudo est obligatoire";
    }
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email n'est pas valide";
    }
    if (empty($mdp)) {
        $erreurs['mdp'] = "Le mot de passe est obligatoire";
    }
    if (empty($mdp_confirmation)) {
        $erreurs['mdp_confirmation'] = "La confirmation du mot de passe est obligatoire";
    }
    if ($mdp_confirmation!=$mdp) {
        $erreurs['mdp_egaux'] = "Les mots de passe saisis ne sont pas identiques";
    } elseif (14<strlen($mdp) || 8>strlen($mdp)) {
        $erreurs['mdp_longueur'] = "Le mot de passe doit être compris entre 8 et 14 caractères..";
    }

    // Tester si l'adresse mail n'existe pas déjà dans la BDD
    $verification = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $verification->execute([$email_utilisateur]);
    $utilisateur = $verification->fetch();
    if ($utilisateur) {
        // email existe
        $erreurs['email_existe'] = "Un compte existe déjà avec cet email !";
    } else {
        // email n'existe pas
        // Traiter les données
        if (empty($erreurs)) {
            // Traitement des données (insertion dans une base de données)
            $mdp_Hash = password_hash($mdp, PASSWORD_DEFAULT);
            $requete = $pdo->prepare('INSERT INTO utilisateur (pseudo_utilisateur,email_utilisateur,mdp_utilisateur) VALUES (?,?,?)');
            $requete->bindParam(1, $pseudo);
            $requete->bindParam(2, $email_utilisateur);
            $requete->bindParam(3, $mdp_Hash);

            // Exécution de la requête
            $requete->execute();

            // Rediriger l'utilisateur vers une autre page du site
            header("Location: ../index.php");
            exit();
        }
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
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gluten:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cinéma - Inscription</title>
    <link rel="shortcut icon" href="./assets/images/camera-reels.svg" />
</head>
<body class="bg-light">
<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>
<div class="container">
    <h1 class="border-bottom border-3 border-primary pt-5">Inscription</h1>
    <div class="w-50 mx-auto shadow my-5 p-4 rounded-5 bg-white">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="pseudo" class="form-label fw-semibold">Pseudo*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['pseudo'])) ? "border border-2 border-danger" : "" ?>"
                       id="pseudo" name="pseudo" value="<?= $pseudo ?>" placeholder="Saisir votre pseudo"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['pseudo'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['pseudo'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label fw-semibold">Email*</label>
                <input type="email"
                       class="form-control <?= (isset($erreurs['email_utilisateur'])) ? "border border-2 border-danger" : "" ?>
                       form-control <?= (isset($erreurs['email_existe'])) ? "border border-2 border-danger" : "" ?>"
                       id="email_utilisateur" name="email_utilisateur" value="<?= $email_utilisateur ?>" placeholder="Saisir un email valide"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['email_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['email_utilisateur'] ?></p>
                <?php endif; ?>
                <?php if (isset($erreurs['email_existe'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['email_existe'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp" class="form-label fw-semibold">Mot de passe*</label>
                <button type="button" class="btn float-end" data-bs-toggle="modal"
                        data-bs-target="#exampleModal5">
                    <i class="bi bi-info-circle"></i>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel5"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel5">Les caractéristiques de votre mot de passe </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>
                                        Votre mot de passe doit contenir entre 8 et 14 caractères
                                    </li>
                                    <li>
                                        Il doit contenir au moins une minuscule, une majuscule et un chiffre
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp'])) ? "border border-2 border-danger" : "" ?>
                       form-control <?= (isset($erreurs['mdp_egaux'])) ? "border border-2 border-danger" : "" ?>
                       form-control <?= (isset($erreurs['mdp_longueur'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp" name="mdp" value="<?= ($erreurs) ? "" : $mdp ?>" placeholder="Saisir votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp_confirmation" class="form-label fw-semibold">Confirmation du mot de passe*</label>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp_confirmation'])) ? "border border-2 border-danger" : "" ?>
                       form-control <?= (isset($erreurs['mdp_egaux'])) ? "border border-2 border-danger" : "" ?>
                       form-control <?= (isset($erreurs['mdp_longueur'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp_confirmation"
                       name="mdp_confirmation" value="<?= ($erreurs) ? "" : $mdp ?>" placeholder="Saisir votre mot de passe à nouveau"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp_confirmation'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_confirmation'] ?></p>
                <?php endif; ?>
            </div>
            <?php if (isset($erreurs['mdp_longueur'])) : ?>
                <p class="form-text text-danger"><?= $erreurs['mdp_longueur'] ?></p>
            <?php endif; ?>
            <?php if (isset($erreurs['mdp_egaux'])) : ?>
                <p class="form-text text-danger"><?= $erreurs['mdp_egaux'] ?></p>
            <?php endif; ?>
            <div class="text-center pt-2">
                <button type="submit" class="btn btn-primary">Inscription</button>
            </div>
            <div class="pt-3">
                <p><span class="me-1">Vous possédez déjà un compte ?</span><a href="./connexion.php" class="link-underline-info text-black fw-semibold mt-5">Connectez vous !</a></p>
            </div>
        </form>
    </div>
</div>


<script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>