<?php

namespace src\Model;

class StaffMember
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $picture;
    private string $role;

    public function __construct(
        string $firstname,
        string $lastname,
        string $picture,
        string $role,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->picture = $picture;
        $this->role = $role;
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

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    // --- Setters ---
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

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    // --- Sélection d’un staff par ID ---
    public static function selectTargetStaff(int $staff_id): StaffMember
    {
        global $connexion;

        $requeteSelection = $connexion->prepare(
            'SELECT * FROM staff_member WHERE id = :id'
        );
        $requeteSelection->bindParam('id', $staff_id);
        $requeteSelection->execute();
        $result = $requeteSelection->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new \Exception("Aucun membre du staff trouvé avec cet ID ($staff_id).");
        }

        $data = $result[0];

        $staff = new StaffMember(
            $data["first_name"],
            $data["last_name"],
            $data["picture"],
            $data["role"],
            (int) $data["id"]  // <-- cast en int
        );


        return $staff;
    }

    // --- Mise à jour d’un staff ---
    public static function updateStaff(StaffMember $staffPost, int $staff_id): void
    {
        global $connexion;

        $firstName = $staffPost->getFirstname();
        $lastName = $staffPost->getLastname();
        $picture = $staffPost->getPicture();
        $role = $staffPost->getRole();

        $requeteUpdate = $connexion->prepare(
            'UPDATE staff_member 
             SET first_name = :firstname, last_name = :lastname, picture = :picture, role = :role
             WHERE id = :id'
        );

        $requeteUpdate->bindParam('id', $staff_id);
        $requeteUpdate->bindParam('firstname', $firstName);
        $requeteUpdate->bindParam('lastname', $lastName);
        $requeteUpdate->bindParam('picture', $picture);
        $requeteUpdate->bindParam('role', $role);
        $requeteUpdate->execute();
    }
}
