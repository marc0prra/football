<?php

namespace src\Model;

class OpposingClub
{
    private ?int $id;
    private string $address;
    private string $city;

    public function __construct($address, $city, ?int $id = null)
    {
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function getAddress(): string
    {
        return $this->address;
    }

    public function insertClub(): void
    {
        global $connexion;
        $city = $this->getCity();
        $adress = $this->getAddress();

        $requeteInsertion = $connexion->prepare('INSERT INTO opposing_club (adress, city) VALUES (:adress, :city)');
        $requeteInsertion->bindParam('adress', $adress);
        $requeteInsertion->bindParam('city', $city);
        $requeteInsertion->execute();

    }

    public static function selectClubs(): array
    {
        global $connexion;
        $requeteSelection = $connexion->prepare(
            'SELECT * FROM opposing_club'
        );
        $requeteSelection->execute();
        $theClubs = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        $counter = 1;
        $clubs = [];

        foreach ($theClubs as $theClub) {
            $clubs[$counter] = new OpposingClub(
                $theClub["adress"],
                $theClub["city"]
            );
            $counter++;
        }
        return $clubs;
    }
}
