<?php
function insertPlayer(Player $player): void
{
    global $connexion;
    $prenom = $player->getFirstname();
    $nom = $player->getLastname();
    $age = $player->getBirthdate()->format('Y-m-d H:i:s');
    $photo = $player->getPicture();

    $requeteInsertion = $connexion->prepare('INSERT INTO player (firstname, lastname, birthdate, picture) 
    VALUES (:prenom, :nom, :age, :photo)');
    $requeteInsertion->bindParam('prenom', $prenom);
    $requeteInsertion->bindParam('nom', $nom);
    $requeteInsertion->bindParam('age', $age);
    $requeteInsertion->bindParam('photo', $photo);
    $requeteInsertion->execute();
}

function insertTeam(Team $team): void
{
    global $connexion;
    $nom = $team->getName();

    $requeteInsertion = $connexion->prepare('INSERT INTO team (name) VALUES (:team)');
    $requeteInsertion->bindParam('team', $nom);
    $requeteInsertion->execute();

}

function insertClub(OpposingClub $opposingClub): void
{
    global $connexion;
    $city = $opposingClub->getCity();
    $adress = $opposingClub->getAddress();

    $requeteInsertion = $connexion->prepare('INSERT INTO opposing_club (adress, city) VALUES (:adress, :city)');
    $requeteInsertion->bindParam('adress', $adress);
    $requeteInsertion->bindParam('city', $city);
    $requeteInsertion->execute();

}

function insertPlayerHasTeam(PlayerHasTeam $playerHasTeam)
{
    global $connexion;
    $playerId = $playerHasTeam->getPlayer();
    $teamId = $playerHasTeam->getTeam();
    $hasTeamRole = $playerHasTeam->getRole();

    $requeteInsertion = $connexion->prepare('INSERT INTO player_has_team (player_id, team_id, `role`) VALUES (:player, :team, :roles)');
    $requeteInsertion->bindParam('player', $playerId);
    $requeteInsertion->bindParam('team', $teamId);
    $requeteInsertion->bindParam('roles', $hasTeamRole);
    $requeteInsertion->execute();
}

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

function selectPlayers(): array
{
    global $connexion;
    $requeteSelection = $connexion->prepare(
        'SELECT * FROM player p 
            LEFT JOIN player_has_team pht ON pht.player_id = p.id'
    );
    $requeteSelection->execute();
    $thePlayers = $requeteSelection->fetchAll(PDO::FETCH_ASSOC);

    $counter = 1;
    $players = [];

    foreach ($thePlayers as $thePlayer) {
        $players[$counter] = new Player(
            $thePlayer["fisrtname"],
            $thePlayer["lastname"],
            $thePlayer["birthdate"],
            $thePlayer["picture"],
            id: $thePlayer["id"]
        );
        $counter++;
    }
    return $players;
}

function selectTeams(): array
{
    global $connexion;
    $requeteSelection = $connexion->prepare(
        'SELECT * FROM team t
            LEFT JOIN player_has_team pht ON pht.team_id = t.id'
    );
    $requeteSelection->execute();
    $theTeams = $requeteSelection->fetchAll(PDO::FETCH_ASSOC);

    $counter = 1;
    $teams = [];

    foreach ($theTeams as $theTeam) {
        $teams[$counter] = new Team(
            $theTeam["name"],
            id: $theTeam["id"]
        );
        $counter++;
    }
    return $teams;
}

function selectClubs(): array
{
    global $connexion;
    $requeteSelection = $connexion->prepare(
        'SELECT * FROM opposing_club'
    );
    $requeteSelection->execute();
    $theClubs = $requeteSelection->fetchAll(PDO::FETCH_ASSOC);

    $counter = 1;
    $clubs = [];

    foreach ($theClubs as $theClub) {
        $clubs[$counter] = new OpposingClub(
            $theClub["adress"],
            $theClub["city"]
        );
        $counter++;
    }
    return $clubs;
}
