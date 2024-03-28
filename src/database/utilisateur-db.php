<?php

require_once '../base.php';
require_once BASE_PATH.'/src/config/db-config.php';

function getEmailUtilisateur($email_utilisateur): array
{
    $pdo = getConnexion();
    $recuperation = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $recuperation->execute([$email_utilisateur]);
    $utilisateur=$recuperation->fetchAll(PDO::FETCH_ASSOC);
    return $utilisateur;
}
function postUtilisateur($mdp,$pseudo,$email_utilisateur): void
{
    $pdo = getConnexion();
    $mdp_Hash = password_hash($mdp, PASSWORD_DEFAULT);
    $requete = $pdo->prepare('INSERT INTO utilisateur (pseudo_utilisateur,email_utilisateur,mdp_utilisateur) VALUES (?,?,?)');
    $requete->bindParam(1, $pseudo);
    $requete->bindParam(2, $email_utilisateur);
    $requete->bindParam(3, $mdp_Hash);
    $requete->execute();
}

function getMdpUtilisateur($email_utilisateur) : array|bool
{
    $pdo = getConnexion();
    $recuperation = $pdo->prepare("SELECT mdp_utilisateur FROM utilisateur WHERE email_utilisateur=?");
    $recuperation->execute([$email_utilisateur]);
    $mdp=$recuperation->fetch(PDO::FETCH_ASSOC);
    return $mdp;
}


function getPseudoUtilisateur($id_utilisateur) : array
{
    $pdo = getConnexion();
    $recuperation = $pdo->prepare("SELECT pseudo_utilisateur FROM utilisateur WHERE id_utilisateur=?");
    $recuperation->execute([$id_utilisateur]);
    $pseudo=$recuperation->fetch(PDO::FETCH_ASSOC);
    return $pseudo;
}

function getIdUtilisateur($email_utilisateur) : array
{
    $pdo = getConnexion();
    $recuperation = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email_utilisateur=?");
    $recuperation->execute([$email_utilisateur]);
    $id_utilisateur=$recuperation->fetch(PDO::FETCH_ASSOC);
    return $id_utilisateur;
}