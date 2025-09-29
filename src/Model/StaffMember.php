<?php

namespace src\Model;

class StaffMember
{
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
