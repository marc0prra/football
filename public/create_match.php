<?php //Objectif : Création des équipes "Matchs"
include_once("index.php");
use src\Model\Matchs;
$teams = selectTeams();
$clubs = selectClubs();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        $match = new Matchs();

    }
}

