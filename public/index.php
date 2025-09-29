<?php

require_once("includes/autoloader.php");

Autoloader::register();

use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\StaffMember;
use src\Model\Team;

include("includes/database.php");
include("../includes/functions.php");
require_once("includes/header.php");
