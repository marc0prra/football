<?php

namespace src\Model;
use src\Model\PlayerRole;


class DatabaseManager
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function getConnexion(): \PDO
    {
        return $this->connexion;
    }

    public function insertPlayer(Player $player): void
    {
        $prenom = $player->getFirstname();
        $nom = $player->getLastname();
        $age = $player->getBirthdate()->format('Y-m-d H:i:s');
        $photo = $player->getPicture();

        $requeteInsertion = $this->connexion->prepare(
            'INSERT INTO player (firstname, lastname, birthdate, picture) 
             VALUES (:prenom, :nom, :age, :photo)'
        );
        $requeteInsertion->bindParam('prenom', $prenom);
        $requeteInsertion->bindParam('nom', $nom);
        $requeteInsertion->bindParam('age', $age);
        $requeteInsertion->bindParam('photo', $photo);
        $requeteInsertion->execute();

        $player->setId((int) $this->connexion->lastInsertId());
    }
    public function insertPlayerHasTeam(PlayerHasTeam $playerHasTeam): void
    {
        $playerId = $playerHasTeam->getPlayer();
        $teamId = $playerHasTeam->getTeam();
        $hasTeamRole = $playerHasTeam->getRole();

        $requeteInsertion = $this->connexion->prepare(
            'INSERT INTO player_has_team (player_id, team_id, `role`) 
             VALUES (:player, :team, :roles)'
        );
        $requeteInsertion->bindParam('player', $playerId);
        $requeteInsertion->bindParam('team', $teamId);
        $requeteInsertion->bindParam('roles', $hasTeamRole);
        $requeteInsertion->execute();
    }

    public static function returnArray(array $infos): array
    {
        foreach ($infos as $keyInfo => $info) {
            $info = trim($info);
            if ($info === "") {
                $infos["errors"][$keyInfo] = "Veuillez renseigner " . $keyInfo;
            }
        }

        if (isset($infos["position"]) && (PlayerRole::tryFrom($infos["position"]) == null)) {
            $infos["errors"]["position"] = "Position incorrect";
        }
        return $infos;
    }

    public function selectPlayers(): array
    {
        $requeteSelection = $this->connexion->prepare(
            'SELECT * FROM player p 
             LEFT JOIN player_has_team pht ON pht.player_id = p.id'
        );
        $requeteSelection->execute();
        $thePlayers = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        $counter = 1;
        $players = [];

        foreach ($thePlayers as $thePlayer) {
            $players[$counter] = new Player(
                $thePlayer["firstname"],
                $thePlayer["lastname"],
                $thePlayer["birthdate"],
                $thePlayer["picture"],
                id: $thePlayer["id"]
            );
            $counter++;
        }
        return $players;
    }

    public function selectClubs(): array
    {
        $requeteSelection = $this->connexion->prepare(
            'SELECT * FROM opposing_club'
        );
        $requeteSelection->execute();
        $theClubs = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

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
}
