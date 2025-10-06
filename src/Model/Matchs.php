<?php

namespace src\Model;

use DateTime;

class Matchs
{
    private ?int $id;
    private int $teamScore;
    private int $opponentScore;
    private DateTime $date;
    private int $team_id;
    private string $city;
    private int $opposing_club_id;

    public function __construct(
        ?int $id = null,
        int $teamScore = 0,
        int $opponentScore = 0,
        DateTime|string $date = "2000-01-01",
        int $team_id = 0,
        string $city = "",
        int $opposing_club_id = 0
    ) {
        $this->id = $id;
        $this->teamScore = $teamScore;
        $this->opponentScore = $opponentScore;
        $this->date = $date instanceof DateTime ? $date : new DateTime($date);
        $this->team_id = $team_id;
        $this->city = $city;
        $this->opposing_club_id = $opposing_club_id;
    }

    // --- Getters ---
    public function getId(): ?int
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

    // --- Setters ---
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setTeamScore(int $teamScore): void
    {
        $this->teamScore = $teamScore;
    }
    public function setOpponentScore(int $opponentScore): void
    {
        $this->opponentScore = $opponentScore;
    }
    public function setDate(DateTime|string $date): void
    {
        $this->date = $date instanceof DateTime ? $date : new DateTime($date);
    }
    public function setTeamId(int $team_id): void
    {
        $this->team_id = $team_id;
    }
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    public function setOpposingClubId(int $opposing_club_id): void
    {
        $this->opposing_club_id = $opposing_club_id;
    }
}
