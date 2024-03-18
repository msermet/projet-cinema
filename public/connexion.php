<?php
// Récupérer la liste des étudiants dans la table etudiant

// 1. Connexion à la base de données db_cinema
/**
 * @var PDO $pdo
 */
require '../src/config/db-config.php';
?>

<?php
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$email_utilisateur = "";
$mdp = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp = $_POST['mdp'];

    //Validation des données
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email n'est pas valide";
    }
    if (empty($mdp)) {
        $erreurs['mdp'] = "Le mot de passe est obligatoire";
    }

    // Tester si l'adresse mail n'existe pas déjà dans la BDD
    $verification_email = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $verification_email->execute([$email_utilisateur]);
    $utilisateur = $verification_email->fetch();

    // Tester si le mot de passe n'existe pas déjà dans la BDD
    $verification_mdp = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $verification_mdp->execute([$email_utilisateur]);
    $utilisateur = $verification_mdp->fetch();
    // #douteux

    if ($utilisateur) {
        // email existe
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

    } else {
        // email n'existe pas
        $erreurs['email_existe'] = "Un compte existe déjà avec cet email !";

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
    <title>Cinéma - Connexion</title>
    <link rel="shortcut icon" href="assets/images/camera-reels.svg" />
</head>
<body class="bg-light">
<!--Insertion d'un menu-->
<?php include_once '../src/_partials/header.php' ?>
<div class="container">
    <h1 class="border-bottom border-3 border-primary pt-5">Connexion</h1>
    <div class="w-50 mx-auto shadow my-5 p-4 rounded-5 bg-white">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label fw-semibold">Email*</label>
                <input type="email"
                       class="form-control <?= (isset($erreurs['email_utilisateur'])) ? "border border-2 border-danger" : "" ?> form-control <?= (isset($erreurs['email_existe'])) ? "border border-2 border-danger" : "" ?>"
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
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp'])) ? "border border-2 border-danger" : "" ?> form-control <?= (isset($erreurs['mdp_egaux'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp" name="mdp" value="<?= ($erreurs) ? "" : $email_utilisateur ?>" placeholder="Saisir votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp'] ?></p>
                <?php endif; ?>
            </div>
            <div class="text-center pt-2">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
            <div class="pt-3">
                <p><span class="me-1">Vous ne possédez pas de compte ?</span><a href="creation-de-compte.php" class="link-underline-info text-black fw-semibold mt-5">Inscrivez vous !</a></p>
            </div>
        </form>
    </div>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>