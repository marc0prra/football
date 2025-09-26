<?php
class PlayerHasTeam
{
    private string $role; // attaquant, milieu, défenseur, gardien
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
}