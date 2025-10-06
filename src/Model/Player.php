<?php

namespace src\Model;

use DateTime;

class Player
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private \DateTime $birthdate;
    private string $picture;

    public function __construct(
        string $firstname = "",
        string $lastname = "",
        DateTime|string $birthdate = "2000-01-01",
        string $picture = "",
        ?int $id = null
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate instanceof DateTime ? $birthdate : new \DateTime($birthdate);
        $this->picture = $picture;
    }

    // Getters
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

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
    public function setBirthdate(DateTime|string $birthdate): void
    {
        $this->birthdate = $birthdate instanceof DateTime ? $birthdate : new DateTime($birthdate);
    }
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }
}
