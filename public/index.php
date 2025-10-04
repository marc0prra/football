<?php

require_once(__DIR__ . '/../includes/autoloader.php');

Autoloader::register();

use src\Model\Player;
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\StaffMember;
use src\Model\Team;

include(__DIR__ . "/../includes/database.php");
include(__DIR__ . "/../includes/functions.php");
require_once(__DIR__ . "/../includes/header.php");
