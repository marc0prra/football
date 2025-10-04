<?php
use src\Model\Player;
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\StaffMember;
use src\Model\Team;

function returnArray(array $infos): array
{
    $errors = "";
    foreach ($infos as $keyInfo => $info) {
        $info = trim($info);
        if (($info) == "") {
            $infos["errors"][$keyInfo] = "Veuillez renseigner " . $keyInfo;
        }
    }
    return $infos;
}
