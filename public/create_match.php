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
    if ((!isset($infos["errors"])) && $infos["score-equipe"] >= 0 && $infos["score-club-oppose"] >= 0) {
        $match = new Matchs(
            $infos["score-equipe"],
            $infos["score-club-oppose"],
            $infos["date-match"],
            $infos["équipe"],
            $infos["city-match"],
            $infos["club"]
        );
        $match->insertMatch();
        $infos = "";
        $_SESSION['success'] = "Le match a bien été enregistré !";
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
    <div>
        <div class="row">
            <div class="column">
                <p class="error">
                    <?php echo isset($infos["errors"]["date-match"]) ? $infos["errors"]["date-match"] : "" ?>
                </p>
                <label for="date-match">Choisissez une date</label><br>
                <input type="date" id="date-match" name="date-match" required>
            </div>
            <div class="column">
                <p class="error">
                    <?php echo isset($infos["errors"]["score-club-oppose"]) ? $infos["errors"]["score-club-oppose"] : "" ?>
                </p>
                <label for="select-city">Ville du match</label><br>
                <input type="text" id="city-match" name="city-match" required>
            </div>
        </div>
        <div class="row">

            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["équipe"]) ? $infos["errors"]["équipe"] : "" ?></p>
                <label for="select-team">Choisissez une équipe</label><br>
                <select name="équipe" id="équipe" required>
                    <?php foreach ($teams as $team) { ?>
                        <option value="<?= htmlspecialchars($team->getId()) ?>">
                            <?= htmlspecialchars($team->getName()) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="column">
                <p class="error">
                    <?php echo isset($infos["errors"]["score-equipe"]) ? $infos["errors"]["score-equipe"] : "" ?>
                </p>
                <label for="select-player">Score équipe</label><br>
                <input type="number" id="score-equipe" name="score-equipe" required>
            </div>

            <div class="column">
                <p class="error">
                    <?php echo isset($infos["errors"]["score-club-oppose"]) ? $infos["errors"]["score-club-oppose"] : "" ?>
                </p>
                <label for="select-player">Score club opposé</label><br>
                <input type="number" id="score-club-oppose" name="score-club-oppose" required>
            </div>

            <div class="column">
                <p class="error"><?php echo isset($infos["errors"]["club"]) ? $infos["errors"]["club"] : "" ?></p>
                <label for="select-team">Choisissez un club</label><br>
                <select name="club" id="club" required>
                    <?php foreach ($clubs as $club) { ?>
                        <option value="<?= htmlspecialchars($club->getId()) ?>">
                            <?= htmlspecialchars($club->getCity()) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

        </div>
    </div>
    </div>

    <button type="submit">Ajouter à l'équipe</button>
</form>