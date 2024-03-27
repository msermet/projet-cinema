<?php
require_once '../base.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';

session_start();
if (!empty($_SESSION)) {
    header("Location: ../index.php");
}
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
    } else {
        // Tester si l'adresse mail existe dans la BDD
        $utilisateur=getEmailUtilisateur($email_utilisateur);
        if (!$utilisateur) {
            // email n'existe pas
            $erreurs['identifiants'] = "Identifiants incorrects";
        } else {
            foreach ($utilisateur as $infoUtilisateur) {
                $pseudo=$infoUtilisateur["pseudo_utilisateur"];
                $id_utilisateur=$infoUtilisateur["id_utilisateur"];
            }
        }
    }

    if (empty($mdp)) {
        $erreurs['mdp'] = "Le mot de passe est obligatoire";
    } else {
        // Tester si le mot de passe correspond au mdp_utilisateur dans la BDD
        $mdpUtilisateur=array(getMdpUtilisateur($email_utilisateur));
        foreach ($mdpUtilisateur as $mdpHash) {
            foreach ($mdpHash as $hash) {
                if (password_verify($mdp, $hash)) {
                    // Démarrer/créer une session
                    session_start();    // PREMIERE INSTRUCTION
                    // Ajouter une variable de session "utilisateur"
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['id_utilisateur'] = $id_utilisateur;
                    header("Location: ../index.php");
                    exit();
                } else {
                    $erreurs['identifiants'] = "Identifiants incorrects";
                }
            }

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
<?php require_once BASE_PROJET.'/src/_partials/header.php' ?>
<div class="container">
    <h1 class="border-bottom border-3 border-primary pt-5">Connexion</h1>
    <div class="w-50 mx-auto shadow my-5 p-4 rounded-5 bg-white">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label fw-semibold">Email*</label>
                <input type="email"
                       class="form-control <?= (isset($erreurs['email_utilisateur'])) ? "border border-2 border-danger" : "" ?> form-control <?= (isset($erreurs['email_existe'])) ? "border border-2 border-danger" : "" ?> form-control <?= (isset($erreurs['identifiants'])) ? "border border-2 border-danger" : "" ?>"
                       id="email_utilisateur" name="email_utilisateur" value="<?= ($erreurs) ? "" : $email_utilisateur ?>" placeholder="Saisir un email valide"
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
                       class="form-control <?= (isset($erreurs['mdp'])) ? "border border-2 border-danger" : "" ?> form-control <?= (isset($erreurs['identifiants'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp" name="mdp" value="<?= ($erreurs) ? "" : $mdp ?>" placeholder="Saisir votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp'] ?></p>
                <?php endif; ?>
                <?php if (isset($erreurs['identifiants'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['identifiants'] ?></p>
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