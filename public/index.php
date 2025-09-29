<?php

require_once("includes/autoloader.php");

Autoloader::register();

use src\Model\Player;
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\StaffMember;
use src\Model\Team;



$player = new Player();
$match = new Matchs();


include("../src/Model/Team.php");
include("../src/Model/PlayerHasTeam.php");
include("../src/Model/Matchs.php");
include("../src/Model/OpposingClub.php");
include("../src/Model/StaffMember.php");
include("includes/database.php");
include("../includes/functions.php");
require_once("includes/header.php");
