<?php

// Définir les informations de connexion


const DB_HOST = "localhost:3306";
const DB_NAME = "db_cinema";
const DB_USER = "root";
const DB_PASSWORD = "";

function getConnexion(): PDO
{
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER, DB_PASSWORD
    );
    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
