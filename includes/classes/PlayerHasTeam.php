<?php
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
}