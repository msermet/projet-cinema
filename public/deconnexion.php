<?php

session_start();
if (empty($_SESSION)) {
    header("Location: connexion.php");
} elseif (!empty($_SESSION)) {
    $_SESSION=[];
    header("Location: /");
}