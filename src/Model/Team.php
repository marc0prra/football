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

    static function selectTeams(): array
    {
        global $connexion;
        $requeteSelection = $connexion->prepare(
            'SELECT * FROM team t
            LEFT JOIN player_has_team pht ON pht.team_id = t.id ORDER BY name'
        );
        $requeteSelection->execute();
        $theTeams = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        $counter = 1;
        $teams = [];

        foreach ($theTeams as $theTeam) {
            $teams[$counter] = new Team(
                $theTeam["name"],
                id: $theTeam["id"]
            );
            $counter++;
        }
        return $teams;
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
