<?php

require_once __DIR__ . "/../includes/autoloader.php";
require_once __DIR__ . "/../includes/database.php";
require_once __DIR__ . "/../includes/header.php";
Autoloader::register();

use src\Model\DatabaseManager;
use src\Model\Player;
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\StaffMember;
use src\Model\Team;
