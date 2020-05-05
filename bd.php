<?php

try {
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=powernmc', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $bdd->exec("SET lc_time_names = 'fr_FR'");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>