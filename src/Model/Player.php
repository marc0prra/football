<?php

namespace src\Model;


class Player
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private \DateTime $birthdate;
    private string $picture;

    public function __construct($firstname, $lastname, \DateTime|string $birthdate, $picture, ?int $id = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate instanceof DateTime ? $birthdate : new \DateTime($birthdate);
        $this->picture = $picture;
    }

    // --- Getters ---
    public function getId(): ?int
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
    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }
    public function getPicture(): string
    {
        return $this->picture;
    }
}
