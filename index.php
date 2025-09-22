<?php
class Player
{
    // --- Attributs ---
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private DateTime $birthdate;
    private string $picture;

    public function __construct($id, $firstname, $lastname, $birthdate, $picture)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = new DateTime($birthdate);
        $this->picture = $picture;
    }

    // --- Getters ---
    public function getId(): int
    {
        return $this->id;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }
    public function getPicture(): string
    {
        return $this->picture;
    }
}

class Team
{
    private ?int $id;
    private string $name;
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

class PlayerHasTeam
{
    private Player $player;
    private Team $team;
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
    public function getPlayer(): int
    {
        return $this->player->getId();
    }
    public function getTeam(): int
    {
        return $this->team->getId();
    }
}

class OpposingClub
{
    private ?int $id;
    private string $address;
    private string $city;

    public function __construct($id, $address, $city)
    {
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function getAddress(): string
    {
        return $this->address;
    }

}

class Matchs
{
    private ?int $id;
    private int $teamScore;
    private int $opponentScore;
    private DateTime $date;

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
}

class StaffMember
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $picture;
    private string $role; // Entraîneur, Préparateur, Analyste

    public function __construct($id, $firstname, $lastname, $picture, $role)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->picture = $picture;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getPicture(): string
    {
        return $this->picture;
    }
    public function getRole(): string
    {
        return $this->role;
    }

}
?>