<?php
include_once("includes/header.php");
include_once("index.php");
// Vérifier qu'on est en POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        //Tout les champs sont remplis ? On peut insérer en BDD
        $player = new Player(
            $infos["first_name"],
            $infos["last_name"],
            new DateTime($infos["birthdate"]),
            $infos["picture"]
        );
        insertPlayer($player);
        $infos = "";
    }
}
?>

<form action="" method="post">
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required><br>
    <label for="last_name">Nom de famille :</label>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="birthdate">Date de naissance :</label>
    <input type="date" id="birthdate" name="birthdate" required><br>
    <label for="picture" placeholder="includes/images/">Photo </label>
    <input type="text" id="picture" name="picture" required><br>

    <button type="submit">Add Player</button>

</form>

<?php
include_once("includes/footer.php");

?>