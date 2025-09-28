<?php //Objectif : Création des équipes "Matchs"
session_start();
include_once("includes/header.php");
include_once("index.php");
$teams = selectTeams();
$clubs = selectClubs();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        $match = new Matchs();
        
    }

}
