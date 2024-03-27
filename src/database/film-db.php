<?php

require_once '../base.php';
require_once BASE_PATH.'/src/config/db-config.php';

// Fonction permettant de récupérer tous les films
function getFilmsListe(): array
{
    $pdo = getConnexion();
    $requete = $pdo->prepare("SELECT * FROM film");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
function getFilmsACcueil(): array
{
    $pdo = getConnexion();
    $requete = $pdo->prepare("SELECT * FROM film ORDER BY id_film DESC LIMIT 4");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
function getDetails(int $id) : array|bool
{
    $pdo = getConnexion();
    $requete = $pdo->prepare("SELECT titre,duree,resume,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_fr,pays,image,id_film,id_utilisateur FROM film WHERE id_film= $id");
    $requete->execute();
    return $requete->fetch(PDO::FETCH_ASSOC);
}

function postFilm($titre,$duree,$resume,$date,$pays,$image,$id_utilisateur): void
{
    $pdo = getConnexion();
    $requete = $pdo->prepare('INSERT INTO film (titre,duree,resume,date_sortie,pays,image,id_utilisateur) VALUES (?,?,?,?,?,?,?)');
    $requete->bindParam(1, $titre);
    $requete->bindParam(2, $duree);
    $requete->bindParam(3, $resume);
    $requete->bindParam(4, $date);
    $requete->bindParam(5, $pays);
    $requete->bindParam(6, $image);
    $requete->bindParam(7, $id_utilisateur);
    $requete->execute();
}

?>
