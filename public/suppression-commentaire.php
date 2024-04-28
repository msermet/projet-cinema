<?php
require_once '../base.php';
require_once BASE_PROJET.'/src/database/film-db.php';
require_once BASE_PROJET.'/src/database/utilisateur-db.php';
require_once BASE_PROJET.'/src/database/commentaire-db.php';
require_once BASE_PROJET."/src/fonctions.php";

session_start();

// Vérifier si la session est vide
if (empty($_SESSION)) {
    header("Location: ../index.php");
    exit(); // Terminer le script pour éviter toute exécution supplémentaire
}

$pseudo = null;
$id_utilisateur = null;

// Récupérer les données de session
if (isset($_SESSION["pseudo"])) {
    $pseudo= $_SESSION["pseudo"];
}
if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur= $_SESSION['id_utilisateur'];
}

$existeCommentaire = null;

// Vérifier si le commentaire existe dans la session
if (isset($_SESSION['existeCommentaire'])) {
    $existeCommentaire= $_SESSION['existeCommentaire'];
} else {
    header("Location: ../index.php");
    exit(); // Terminer le script pour éviter toute exécution supplémentaire
}

$id = null;
$erreur=false;

// Vérifier si l'ID du film est fourni dans les paramètres GET
if (isset($_GET["id"])) {
    $id = filter_var($_GET["id"],FILTER_VALIDATE_INT);
    $film = getDetails($id);
    if ($film==null) {
        $erreur=true;
    }
} else {
    $erreur=true;
}

if ($id && !$erreur) {
    $commentaires = getCommentaire($id);

    // Traiter les données (supprimer le commentaire de la base de données)
    deleteCommentaire($id_utilisateur,$id);
    $_SESSION["existeCommentaire"]=[];

    // Rediriger l'utilisateur vers la page des détails du film
    header("Location: details.php?id=$id");
    exit(); // Terminer le script après la redirection
} else {
    // Rediriger l'utilisateur vers la page d'accueil si une erreur est survenue
    header("Location: ../index.php");
    exit(); // Terminer le script après la redirection
}
