<?php //Objectif : Création des équipes "Matchs"
include_once("index.php");
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
$teams = PlayerHasTeam::selectTeams();
$clubs = OpposingClub::selectClubs();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        $match = new Matchs();

    }
}

