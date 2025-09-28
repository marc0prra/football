<?php
include_once("includes/header.php");
include_once("index.php");
// --- Connexion BDD ---
$pdo = new PDO("mysql:host=localhost;dbname=football;charset=utf8mb4", "root", "");

// --- Vérification de l'ID ---
$_GET["id"] = 13;
if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    $requeteSelection = $connexion->prepare(
        'SELECT * FROM player
            WHERE id = :id'
    );
    $requeteSelection->bindParam('id', $player_id);
    $requeteSelection->execute();
    $getThePlayer = $requeteSelection->fetchAll(PDO::FETCH_ASSOC);

    $player = new Player(
        $getThePlayer[0]["firstname"],
        $getThePlayer[0]["lastname"],
        new DateTime($getThePlayer[0]["birthdate"]),
        $getThePlayer[0]["picture"],
        $getThePlayer[0]["id"]
    );
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        $playerPost = new Player(
            $infos["firstname"], 
            $infos["lastname"], 
            new DateTime($infos["birthdate"]),
        $infos["picture"] );

        $firstName = $playerPost->getFirstname();
        $lastName = $playerPost->getLastname();
        $birthDate = $playerPost->getBirthdate()->format('Y-m-d H:i:s');
        $picture = $playerPost->getPicture();

        $requeteUpdate = $connexion->prepare(
            'UPDATE player 
            SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate, picture = :picture
            WHERE id = :id'
        );
        $requeteUpdate->bindParam('id', $player_id);
        $requeteUpdate->bindParam('firstname', $firstName);
        $requeteUpdate->bindParam('lastname', $lastName);
        $requeteUpdate->bindParam('birthdate', $birthDate);
        $requeteUpdate->bindParam('picture', $picture);
        $requeteUpdate->execute();
        $getThePlayer = $requeteUpdate->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Modifier joueur</title>
</head>

<body>
    <h1>Modifier le joueur</h1>

    <form method="post">
        <label>Prénom :</label><br>
        <input type="text" name="firstname" value="<?= isset($playerPost) ? $playerPost->getFirstname() : htmlspecialchars($player->getFirstname()) ?>" required><br><br>

        <label>Nom :</label><br>
        <input type="text" name="lastname" value="<?= isset($playerPost) ? $playerPost->getLastname() : htmlspecialchars($player->getLastname()) ?>" required><br><br>

        <label>Date de naissance :</label><br>
        <input type="date" name="birthdate" value="<?= isset($playerPost) ? $playerPost->getBirthdate()->format('Y-m-d') : htmlspecialchars($player->getBirthdate()->format('Y-m-d')) ?>"
            required>
        <br><br>

        <label>Photo :</label><br>
        <input type="text" name="picture" value="<?= isset($playerPost) ? $playerPost->getPicture() : htmlspecialchars($player->getPicture()) ?>"><br><br>

        <button type="submit">Modifier</button>
    </form>
</body>

</html>