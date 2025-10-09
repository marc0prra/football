<?php //Objectif : Création des équipes "Matchs"
include_once("index.php");
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\Team;
use src\Model\DatabaseManager;

$teams = Team::selectTeams();
$clubs = OpposingClub::selectClubs();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = DatabaseManager::returnArray($_POST);
    if (!isset($infos["errors"])) {
        $match = new Matchs();

    }
}
