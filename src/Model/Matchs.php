<?php
class Matchs
{
    private ?int $id;
    private int $teamScore;
    private int $opponentScore;
    private DateTime $date;

    private int $team_id;

    private string $city;

    private int $opposing_club_id;

    public function __construct(?int $id = null, $teamScore, $opponentScore, $date, $team_id, $city, $opposing_club_id)
    {
        $this->id = $id;
        $this->teamScore = $teamScore;
        $this->opponentScore = $opponentScore;
        $this->date = $date instanceof DateTime ? $date : new DateTime($date);
        $this->team_id = $team_id;
        $this->city = $city;
        $this->opposing_club_id = $opposing_club_id;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getTeamId(): int
    {
        return $this->team_id;
    }
    public function getCity(): string
    {
        return $this->city;
    }

        public function getOpposingClubId(): int
    {
        return $this->opposing_club_id;
    }
}