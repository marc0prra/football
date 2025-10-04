<?php

namespace src\Model;

class PlayerHasTeam
{
    private string $role; // attaquant, milieu, défenseur, gardien
    private int $player_id;
    private int $team_id;
    public function __construct(int $player_id, int $team_id, string $role)
    {
        $this->player_id = $player_id;
        $this->team_id = $team_id;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPlayer(): int
    {
        return $this->player_id;
    }

    public function getTeam(): int
    {
        return $this->team_id;
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

    static function selectTeams(): array
    {
        global $connexion;
        $requeteSelection = $connexion->prepare(
            'SELECT * FROM team t
            LEFT JOIN player_has_team pht ON pht.team_id = t.id ORDER BY name'
        );
        $requeteSelection->execute();
        $theTeams = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

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

}