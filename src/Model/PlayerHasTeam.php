<?php

namespace src\Model;
use src\Model\PlayerRole;

class PlayerHasTeam
{
    private PlayerRole $role; // attaquant, milieu, défenseur, gardien
    private Player $player;
    private Team $team;
    public function __construct(Player $player, Team $team, PlayerRole|string $role)
    {
        $this->player = $player;
        $this->team = $team;
        $this->role = $role instanceof PlayerRole ? $role : PlayerRole::from($role);
    }

    public function getRole(): string
    {
        return $this->role->value;
    }

    public function getPlayer(): int
    {
        return $this->player->getId();
    }

    public function getTeam(): int
    {
        return $this->team->getId();
    }

    public function getTeamName()
    {
        return $this->team->getName();
    }

    public function insertPlayerHasTeam()
    {
        global $connexion;
        $playerId = $this->getPlayer();
        $teamId = $this->getTeam();
        $hasTeamRole = $this->getRole();

        $requeteInsertion = $connexion->prepare('INSERT INTO player_has_team (player_id, team_id, `role`) VALUES (:player, :team, :roles)');
        $requeteInsertion->bindParam('player', $playerId);
        $requeteInsertion->bindParam('team', $teamId);
        $requeteInsertion->bindParam('roles', $hasTeamRole);
        $requeteInsertion->execute();
    }

    static function selectTargetPlayerHasTeam(int $player_id, Player $player): array
    {
        global $connexion;

        $selectTargetPlayerHasTeam = $connexion->prepare('SELECT t.id, name, role FROM team t JOIN player_has_team pht on pht.team_id = t.id WHERE pht.player_id = :id');
        $selectTargetPlayerHasTeam->bindParam('id', $player_id);
        $selectTargetPlayerHasTeam->execute();
        $playersHasTeamsData = $selectTargetPlayerHasTeam->fetchAll(\PDO::FETCH_ASSOC);


        $playersHasTeams = [];
        $counter = 0;
        foreach ($playersHasTeamsData as $playerHasTeamData) {
            $teamsPlayer = new Team(
                $playerHasTeamData["name"],
                $playerHasTeamData["id"]
            );

            $playersHasTeams[] = new PlayerHasTeam(
                $player,
                $teamsPlayer,
                $playerHasTeamData["role"]
            );
            $counter = $counter + 1;
        }

        return $playersHasTeams;
    }
}
