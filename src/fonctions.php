<?php
function convertirEnHeuresMinutes($dureeEnMinutes){
    $heures = floor($dureeEnMinutes / 60);
    $minutes = $dureeEnMinutes % 60;
    return "$heures h $minutes min";
}

function genererEtoiles($note) {
    if ($note < 0 || $note > 5) {
        return "Note invalide. La note doit être comprise entre 0 et 5.";
    }
    $fullStars = floor($note);
    $hasHalfStar = ($note - $fullStars) >= 0.5;
    $starsHTML = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $starsHTML .= '<i class="bi bi-star-fill"></i>';
    }
    if ($hasHalfStar) {
        $starsHTML .= '<i class="bi bi-star-half"></i>';
        $fullStars++;
    }
    $emptyStars = 5 - $fullStars;
    for ($i = 0; $i < $emptyStars; $i++) {
        $starsHTML .= '<i class="bi bi-star"></i>';
    }
    return $starsHTML;
}