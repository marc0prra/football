<?php

use src\Model\DatabaseManager;

include_once("index.php");
use src\Model\Player;
use src\Model\Team;
use src\Model\PlayerHasTeam;
use src\Model\PlayerRole;

// --- Vérification de l'ID ---
if (isset($_GET['id'])) {

    // --- On récupère le joueur ---
    $player = Player::selectTargetPlayer($player_id = $_GET['id']);
    // --- On récupère le nom des équipes du joueur et la position du joueur ---
    $theTeamsName = PlayerHasTeam::selectTargetPlayerHasTeam($player_id, $player);
    // --- On récupère le nom de TOUTES les équipes ---
    $allTeams = Team::selectTeams();
}

// --- !!!!! A tansformer en énumérations dans la classe PlayerHasTeam !!!!! ---
$types = PlayerRole::cases();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $infos = DatabaseManager::returnArray($_POST);

    if (!isset($infos["errors"])) {
        if (isset($infos["firstname"])) {

            $playerPost = new Player(
                $infos["firstname"],
                $infos["lastname"],
                $infos["birthdate"],
                $infos["picture"]
            );

            Player::updatePlayer($playerPost, $player_id);

            $_SESSION['joueur'] = "Le joueur a bien modifié !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $player_id);
            exit;
        }

        if (isset($infos["joueur"]) && !isset($infos["errors"]["position"])) {
            $targetTeam = Team::selectTargetTeam($infos["équipe"]);

            $teamAssignment = new PlayerHasTeam(
                $player,
                $targetTeam,
                $infos["position"]
            );

            $dbManager = new DatabaseManager($connexion);
            $dbManager->insertPlayerHasTeam($teamAssignment);
            $_SESSION['equipe'] = "Le joueur a bien été assigné à une équipe !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $player_id);
            exit;
        }
    }
}
?>

<body>
    <div class="row gap6">
        <div>
            <h1>Modifier le joueur</h1>
            <?php if (isset($_SESSION['joueur'])): ?>
                <div class="success"><?= $_SESSION['joueur'];
                unset($_SESSION['joueur']); ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Prénom :</label><br>
                <input type="text" name="firstname" value="<?= htmlspecialchars($player->getFirstname()) ?>"
                    required><br><br>

                <label>Nom :</label><br>
                <input type="text" name="lastname" value="<?= htmlspecialchars($player->getLastname()) ?>"
                    required><br><br>

                <label>Date de naissance :</label><br>
                <input type="date" name="birthdate" value="<?= $player->getBirthdate()->format('Y-m-d') ?>"
                    required><br><br>

                <label>Photo :</label><br>
                <input type="text" name="picture" value="<?= htmlspecialchars($player->getPicture()) ?>"><br><br>

                <button type="submit">Modifier</button>
            </form>
        </div>

        <div>
            <h1>Ajouter le joueur dans une équipe</h1>
            <?php if (isset($_SESSION['equipe'])): ?>
                <div class="success"><?= $_SESSION['equipe'];
                unset($_SESSION['equipe']); ?></div>
            <?php endif; ?>
            <?php if (!empty($theTeamsName)): ?>
                <ul>
                    <?php foreach ($theTeamsName as $key => $theTeam): ?>
                        <form method="POST">
                            <li class="row">
                                <label for="selected_team"></label>
                                <input type="text" name="selected_team" value="<?= htmlspecialchars($theTeam->getTeamName()) ?>" readonly>
                                <label for="selected_team"></label>
                                <input type="text" name="selected_team" value="<?= htmlspecialchars($theTeam->getRole()) ?>" readonly>
                                <button type="submit">❌</button>
                            </li>
                        </form>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Le joueur n'est associé à aucun club pour le moment.</p>
            <?php endif; ?>

            <form method="post">
                <label for="select-team">Choisissez une équipe</label><br>
                <select name="équipe" id="équipe">
                    <?php foreach ($allTeams as $t): ?>
                        <option value="<?= $t->getId() ?>"><?= htmlspecialchars($t->getName()) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="select-type">Choisissez une position pour le joueur</label><br>
                <select name="position" id="position">
                    <option value="none">--------</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= htmlspecialchars($type->name) ?>"><?= htmlspecialchars($type->value) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="hidden" name="joueur" value="<?= $player->getId() ?>">

                <button type="submit">Ajouter à l'équipe</button>
            </form>
        </div>
    </div>
</body>

</html>