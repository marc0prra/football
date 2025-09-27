<?php //Objectif : Création des équipes "player_has_team"
include("index.php");
$players = selectPlayers();
$teams = selectTeams();
$types = ["Attaquant", "Milieu", "Défenseur", "Gardien"];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        //Tout les champs sont remplis ? On peut insérer en BDD
        $playHasTeam = new PlayerHasTeam(
            $infos["player"],
            $infos["team"],
            $infos["type"]
        );
        insertPlayerHasTeam($playHasTeam);
        $infos = "";
    }
}

?>

<form action="" method="post">
    <label for="select-player">Choisissez un joueur</label><br>
    <select name="player" id="player">
        <?php foreach ($players as $player) { ?>
            <option value="<?= htmlspecialchars($player->getId()) ?>">
                <?= htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="select-team">Choisissez une équipe</label><br>
    <select name="team" id="team">
        <?php foreach ($teams as $team) { ?>
            <option value="<?= htmlspecialchars($team->getId()) ?>">
                <?= htmlspecialchars($team->getName()) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="select-type">Choisissez une position pour le joueur</label><br>
    <select name="type" id="type">
        <?php foreach ($types as $type) { ?>
            <option value="<?= htmlspecialchars($type) ?>">
                <?= htmlspecialchars($type) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Add Player</button>
</form>