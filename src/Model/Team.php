<?php

namespace src\Model;

class Team
{
    private ?int $id;
    private string $name;
    public function __construct(string $name, ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function insertTeam(): void
{
    global $connexion;
    $nom = $this->getName();

    $requeteInsertion = $connexion->prepare('INSERT INTO team (name) VALUES (:team)');
    $requeteInsertion->bindParam('team', $nom);
    $requeteInsertion->execute();

}

}
