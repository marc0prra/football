<?php //Objectif : Création des équipes "Matchs"
include_once("index.php");
use src\Model\Matchs;
use src\Model\OpposingClub;
use src\Model\PlayerHasTeam;
use src\Model\Team;
use src\Model\DatabaseManager;

$teams = Team::selectTeams();
$clubs = OpposingClub::selectClubs();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = DatabaseManager::returnArray($_POST);
    if (!isset($infos["errors"])) {
        $match = new Matchs();

    }
}

?>

<h1>Création d'un match</h1>

<form action="" method="post">
    <div>
        <p class="error"><?php echo isset($infos["errors"]["joueur"]) ? $infos["errors"]["joueur"] : "" ?></p>
        <label for="date-match">Choisissez une date</label><br>
        <input type="date" id="date-match" name="date-match" required><br><br>

        <div class="row">
            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["équipe"]) ? $infos["errors"]["équipe"] : "" ?></p>
                <label for="select-team">Choisissez une équipe</label><br>
                <select name="équipe" id="équipe">
                    <?php foreach ($teams as $team) { ?>
                        <option value="<?= htmlspecialchars($team->getId()) ?>">
                            <?= htmlspecialchars($team->getName()) ?>
                        </option>
                    <?php } ?>
                </select>
            </div><br><br>
            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["position"]) ? $infos["errors"]["position"] : "" ?>
                </p>
                <label for="select-type">Choisissez une position pour le joueur</label><br>
                <select name="position" id="position">
                    <?php foreach ($types as $type) { ?>
                        <option value="<?= htmlspecialchars($type) ?>">
                            <?= htmlspecialchars($type) ?>
                        </option>
                    <?php } ?>
                </select>
            </div><br><br>
            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["joueur"]) ? $infos["errors"]["joueur"] : "" ?></p>
                <label for="select-player">Choisissez un joueur</label><br>
                <input type="" id="date-match" name="date-match" required><br><br>
            </div><br><br>
            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["équipe"]) ? $infos["errors"]["équipe"] : "" ?></p>
                <label for="select-team">Choisissez un club</label><br>
                <select name="équipe" id="équipe">
                    <?php foreach ($teams as $team) { ?>
                        <option value="<?= htmlspecialchars($team->getId()) ?>">
                            <?= htmlspecialchars($team->getName()) ?>
                        </option>
                    <?php } ?>
                </select>
            </div><br><br>
        </div>
        <div class="column"></div>
        <p class="error"><?php echo isset($infos["errors"]["position"]) ? $infos["errors"]["position"] : "" ?></p>
        <label for="select-type">Choisissez une position pour le joueur</label><br>
        <select name="position" id="position">
            <?php foreach ($types as $type) { ?>
                <option value="<?= htmlspecialchars($type) ?>">
                    <?= htmlspecialchars($type) ?>
                </option>
            <?php } ?>
        </select>
    </div><br><br>
    </div>

    <button type="submit">Ajouter à l'équipe</button>
</form>