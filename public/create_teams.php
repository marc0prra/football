<?php //Objectif : Création des équipes "player_has_team"
include_once("index.php");
use src\Model\PlayerHasTeam;
$players = selectPlayers();
$teams = selectTeams();
$types = ["Attaquant", "Milieu", "Défenseur", "Gardien"];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        //Tout les champs sont remplis ? On peut insérer en BDD
        $playHasTeam = new PlayerHasTeam(
            $infos["joueur"],
            $infos["équipe"],
            $infos["position"]
        );
        insertPlayerHasTeam($playHasTeam);
        $infos = "";
        $_SESSION['success'] = "Le joueur a bien été assigné à une équipe !";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="success">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <p class="error"><?php echo isset($infos["errors"]["joueur"]) ? $infos["errors"]["joueur"] : "" ?></p>
    <label for="select-player">Choisissez un joueur</label><br>
    <select name="joueur" id="joueur">
        <?php foreach ($players as $player) { ?>
            <option value="<?= htmlspecialchars($player->getId()) ?>">
                <?= htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <p class="error"><?php echo isset($infos["errors"]["équipe"]) ? $infos["errors"]["équipe"] : "" ?></p>
    <label for="select-team">Choisissez une équipe</label><br>
    <select name="équipe" id="équipe">
        <?php foreach ($teams as $team) { ?>
            <option value="<?= htmlspecialchars($team->getId()) ?>">
                <?= htmlspecialchars($team->getName()) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <p class="error"><?php echo isset($infos["errors"]["position"]) ? $infos["errors"]["position"] : "" ?></p>
    <label for="select-type">Choisissez une position pour le joueur</label><br>
    <select name="position" id="position">
        <?php foreach ($types as $type) { ?>
            <option value="<?= htmlspecialchars($type) ?>">
                <?= htmlspecialchars($type) ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Ajouter à l'équipe</button>
</form>

<?php
require_once(__DIR__ . '/../includes/footer.php');
?>
