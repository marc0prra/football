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


    public function insertPlayer(): void
    {
        global $connexion;
        $prenom = $this->getFirstname();
        $nom = $this->getLastname();
        $age = $this->getBirthdate()->format('Y-m-d H:i:s');
        $photo = $this->getPicture();

        $requeteInsertion = $connexion->prepare('INSERT INTO player (firstname, lastname, birthdate, picture) 
        VALUES (:prenom, :nom, :age, :photo)');
        $requeteInsertion->bindParam('prenom', $prenom);
        $requeteInsertion->bindParam('nom', $nom);
        $requeteInsertion->bindParam('age', $age);
        $requeteInsertion->bindParam('photo', $photo);
        $requeteInsertion->execute();
    }


    static function selectPlayers(): array
    {
        global $connexion;
        $requeteSelection = $connexion->prepare(
            'SELECT * FROM player p 
            LEFT JOIN player_has_team pht ON pht.player_id = p.id'
        );
        $requeteSelection->execute();
        $thePlayers = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        $counter = 1;
        $players = [];

        foreach ($thePlayers as $thePlayer) {
            $players[$counter] = new Player(
                $thePlayer["firstname"],
                $thePlayer["lastname"],
                $thePlayer["birthdate"],
                $thePlayer["picture"],
                id: $thePlayer["id"]
            );
            $counter++;
        }
        return $players;
    }

    static function selectTargetPlayer(int $player_id): Player
    {
        global $connexion;

        $requeteSelection = $connexion->prepare(
            'SELECT * FROM player
            WHERE id = :id'
        );
        $requeteSelection->bindParam('id', $player_id);
        $requeteSelection->execute();
        $getThePlayer = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        $player = new Player(
            $getThePlayer[0]["firstname"],
            $getThePlayer[0]["lastname"],
            $getThePlayer[0]["birthdate"],
            $getThePlayer[0]["picture"],
            $getThePlayer[0]["id"]
        );

        return $player;
    }

}
