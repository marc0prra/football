<?php
class Player
{
    private string $firstname;
    private string $lastname;
    private DateTime $birthdate;
    private string $picture;

    public function __construct($firstname, $lastname, DateTime $birthdate, $picture)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
    }

    // --- Getters ---
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
