<?php
include_once("includes/header.php");
include_once("index.php");
// Vérifier qu'on est en POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Trimming
    $_POST["first_name"] = trim($_POST["first_name"] ?? '');
    $_POST["last_name"] = trim($_POST["last_name"] ?? '');
    $_POST["birthdate"] = trim($_POST["birthdate"] ?? '');
    $_POST["picture"] = trim($_POST["picture"] ?? '');

    $players = $_POST;
    // Si UN des champs (qui sont obligatoires) est vide => ERREUR 

    if (empty($players["first_name"]) || empty($players["last_name"]) || empty($players["birthdate"]) || empty($players["picture"])) {
        if (empty($players["first_name"])) {
            $errors["first_name"] = "Veuillez renseigner le prénom";
        } else if (empty($players["last_name"])) {
            $errors["last_name"] = "Veuillez renseigner le nom";
        } else if (empty($players["birthdate"])) {
            $errors["birthdate"] = "Veuillez renseigner la date de naissance";
        } else if (empty($players["picture"])) {
            $errors["picture"] = "Veuillez renseigner une image";
        }
        $errors["global"] = "Veuillez remplir tous les champs";

    } else if (true == true) {
        echo ("CACA");
        //Tout les champs sont remplis ? On peut insérer en BDD
        $requeteInsertion = $connexion->prepare('
        INSERT INTO player (firstname, lastname, birthdate, picture) VALUES (:prenom, :nom, :age, :photo)');

        $requeteInsertion->bindParam('prenom', $players["first_name"]);
        $requeteInsertion->bindParam('nom', $players["last_name"]);
        $requeteInsertion->bindParam('age', $players["birthdate"]);
        $requeteInsertion->bindParam('photo', $players["picture"]);
        $requeteInsertion->execute();
    }
}

?>

<form action="" method="post">
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required><br>
    <label for="last_name">Nom de famille :</label>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="birthdate">Date de naissance :</label>
    <input type="Date" id="birthdate" name="birthdate" required><br>
    <label for="picture" placeholder="includes/images/">Photo </label>
    <input type="text" id="picture" name="picture" required><br>
    
    <button type="submit">Add Player</button>

</form>

<?php
include_once("includes/footer.php");

?>