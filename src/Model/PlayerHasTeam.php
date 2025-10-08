<?php

namespace src\Model;

class PlayerHasTeam
{
    private string $role; // attaquant, milieu, défenseur, gardien
    private Player $player;
    private Team $team;
    public function __construct(Player $player, Team $team, string $role)
    {
        $this->player = $player;
        $this->team = $team;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPlayer(): int
    {
        return $this->player->getId();
    }

    public function getTeam(): int
    {
        return $this->team->getId();
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
            $counter = $counter+1;
        }

        var_dump($playersHasTeams[1]->team->getName());
        return $playersHasTeams;
    }
}
