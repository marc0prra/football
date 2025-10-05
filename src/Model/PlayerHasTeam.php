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

        static function selectTargetPlayerHasTeam(int $player_id): array
    {
        global $connexion;

        $selectTargetPlayerHasTeam = $connexion->prepare('SELECT * FROM player_has_team WHERE player_id = :id');
        $selectTargetPlayerHasTeam->bindParam('id', $player_id);
        $selectTargetPlayerHasTeam->execute();
        $theTeams = $selectTargetPlayerHasTeam->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($theTeams);
        $teamsOfPlayer = [];

        foreach ($theTeams as $theTeam) {
            $players[] = new PlayerHasTeam(
                $theTeam["name"],
                $theTeam["id"],
            );
        }

        return $teamsOfPlayer;
    }



}