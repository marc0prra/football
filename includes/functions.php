<?php
function insertPlayer(Player $player): void
{
    global $connexion;
    $prenom = $player->getFirstname();
    $nom = $player->getLastname();
    $age = $player->getBirthdate()->format('Y-m-d H:i:s');
    $photo = $player->getPicture();

    $requeteInsertion = $connexion->prepare('INSERT INTO player (firstname, lastname, birthdate, picture) 
    VALUES (:prenom, :nom, :age, :photo)');
    $requeteInsertion->bindParam('prenom', $prenom);
    $requeteInsertion->bindParam('nom', $nom);
    $requeteInsertion->bindParam('age', $age);
    $requeteInsertion->bindParam('photo', $photo);
    $requeteInsertion->execute();
}

function insertTeam(Team $team): void
{
    global $connexion;
    $nom = $team->getName();

    $requeteInsertion = $connexion->prepare('INSERT INTO team (name) VALUES (:team)');
    $requeteInsertion->bindParam('team', $nom);
    $requeteInsertion->execute();

}

function returnArray(array $infos)
{
    $errors = "";
    foreach ($infos as $keyInfo => $info) {
        $info = trim($info);
    }
    if (empty($infos)) {
        $infos["errors"][$keyInfo] = "Les champs obligatoires doivent être remplis";
    } else {
        foreach ($infos as $keyInfo => $info) {
            if (($info) == "") {
                $infos["errors"][$keyInfo] = "Veuillez renseigner " . $keyInfo;
            }
        }
    }
    return $infos;
}