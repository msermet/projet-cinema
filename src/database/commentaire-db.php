<?php

require_once '../base.php';
require_once BASE_PATH.'/src/config/db-config.php';

// Fonction permettant de récupérer tous les films

function postCommentaireFilm($titre,$avis,$note,$date,$heure,$id_utilisateur,$id_film): void
{
    $pdo = getConnexion();
    $requete = $pdo->prepare('INSERT INTO commentaire (titre_commentaire,avis_commentaire,note_commentaire,date_commentaire,heure_commentaire,id_utilisateur,id_film) VALUES (?,?,?,?,?,?,?)');
    $requete->bindParam(1, $titre);
    $requete->bindParam(2, $avis);
    $requete->bindParam(3, $note);
    $requete->bindParam(4, $date);
    $requete->bindParam(5, $heure);
    $requete->bindParam(6, $id_utilisateur);
    $requete->bindParam(7, $id_film);
    $requete->execute();
}

function getCommentaire($id_film): array
{
    $pdo = getConnexion();
    $requete = $pdo->prepare("SELECT titre_commentaire,avis_commentaire,note_commentaire,date_commentaire,heure_commentaire,id_utilisateur,id_film FROM commentaire WHERE id_film=$id_film ORDER BY date_commentaire DESC,heure_commentaire DESC");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
function getMoyenneEtNbCommentaires($id_film): array
{
    $pdo = getConnexion();
    $requete = $pdo->prepare("SELECT AVG(note_commentaire) AS 'moyenne',COUNT(note_commentaire) AS 'nombre_commentaires' FROM commentaire WHERE id_film='$id_film'");
    $requete->execute();
    return $requete->fetch(PDO::FETCH_ASSOC);
}

