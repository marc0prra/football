<?php
class Matchs
{
    private int $teamScore;
    private int $opponentScore;
    private DateTime $date;
    private string $city;

    public function __construct($id, $teamScore, $opponentScore, $date)
    {
        $this->id = $id;
        $this->teamScore = $teamScore;
        $this->opponentScore = $opponentScore;
        $this->date = new DateTime($date);
    }
    public function getTeamScore(): int
    {
        return $this->teamScore;
    }
    public function getOpponentScore(): int
    {
        return $this->opponentScore;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public function getCity(): string
    {
        return $this->city;
    }
}