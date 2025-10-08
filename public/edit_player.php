<?php

use src\Model\DatabaseManager;
include_once("index.php");
use src\Model\Player;
use src\Model\Team;
use src\Model\PlayerHasTeam;

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
$types = ["Attaquant", "Milieu", "Défenseur", "Gardien"];

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

            $firstName = $playerPost->getFirstname();
            $lastName = $playerPost->getLastname();
            $birthDate = $playerPost->getBirthdate()->format('Y-m-d H:i:s');
            $picture = $playerPost->getPicture();

            // --- Mise à jour des infos du joueur en BD ---
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

            $_SESSION['joueur'] = "Le joueur a bien modifié !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $player_id);
            exit;
        }

        if (isset($infos["joueur"])) {
            $teamAssignment = new PlayerHasTeam(
                $infos["joueur"],
                $infos["équipe"],
                $infos["position"]
            );
            $db->insertPlayerHasTeam($teamAssignment);
            $_SESSION['equipe'] = "Le joueur a bien été assigné à une équipe !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $player_id);
            exit;
        }
    }
}
?>

<body>
    <div class="row gap5">
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
                        <li><?= htmlspecialchars($theTeam->getTeamName()) ?> : <?= htmlspecialchars($theTeam->getRole()) ?>
                        </li>
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
                    <?php foreach ($types as $type): ?>
                        <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="hidden" name="joueur" value="<?= $player->getId() ?>">

                <button type="submit">Ajouter à l'équipe</button>
            </form>
        </div>
    </div>
</body>

</html>
<?php
require_once(__DIR__ . '/../includes/footer.php');
?>
