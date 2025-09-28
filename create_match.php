<?php //Objectif : Création des équipes "Matchs"
session_start();
include_once("includes/header.php");
include_once("index.php");
$teams = selectTeams();
$clubs = selectClubs();