<?php //Objectif : Ajout d'équipes dans la BDD
include_once("../index.php");
use src\Model\Team;
use src\Model\DatabaseManager;

// Vérifier qu'on est en POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = DatabaseManager::returnArray($_POST);
    if (!isset($infos["errors"])) {
        //Tout les champs sont remplis ? On peut insérer en BDD
        $team = new Team($infos["team"]);
        $team->insertTeam();
    }
}
?>

<form action="" method="post">
    <?php if (isset($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    } ?>
    <br>
    <label for="team">Nom de l'équipe :</label>
    <input type="text" id="team" name="team" required><br>

    <button type="submit">Add Player</button>
</form>
