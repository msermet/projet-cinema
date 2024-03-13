<?php function convertirEnHeuresMinutes($dureeEnMinutes)
{
    $heures = floor($dureeEnMinutes / 60);
    $minutes = $dureeEnMinutes % 60;
    return "$heures h $minutes min";
}
