<?php
session_start();

require_once __DIR__ . "/includes/autoloader.php";
Autoloader::register();

require_once __DIR__ . "/includes/database.php";

use src\Model\DatabaseManager;
use src\Model\Player;
use src\Model\PlayerHasTeam;
use src\Model\Team;

$db = new DatabaseManager($connexion);

if (!isset($_GET['id'])) {
    die("ID du joueur manquant !");
}

$player_id = (int) $_GET['id'];

$players = $db->selectPlayers();
$player = null;
foreach ($players as $p) {
    if ($p->getId() === $player_id) {
        $player = $p;
    }
}
if (!$player) {
    die("Joueur introuvable !");
}

$playerTeams = [];
$allTeams = $db->selectTeams();
$theTeams = $db->getConnexion()->prepare('SELECT * FROM player_has_team WHERE player_id = :id');
$theTeams->bindParam('id', $player_id);
$theTeams->execute();
$playerTeamsRaw = $theTeams->fetchAll(PDO::FETCH_ASSOC);

foreach ($playerTeamsRaw as $pt) {
    $playerTeams[] = new PlayerHasTeam($pt["player_id"], $pt["team_id"], $pt["role"]);
}

$types = ["Attaquant", "Milieu", "Défenseur", "Gardien"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $infos = $db->returnArray($_POST);

    if (!isset($infos["errors"])) {
        if (isset($infos["firstname"])) {
            $playerPost = new Player(
                $infos["firstname"],
                $infos["lastname"],
                new DateTime($infos["birthdate"]),
                $infos["picture"],
                $player->getId()
            );
            $db->insertPlayer($playerPost);
            $_SESSION['joueur'] = "Le joueur a bien été modifié !";
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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier joueur</title>
    <link rel="stylesheet" href="includes/style.css?v=3">
</head>

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

            <?php if (!empty($playerTeams)): ?>
                <ul>
                    <?php foreach ($playerTeams as $pt): ?>
                        <?php
                        $teamName = "";
                        foreach ($allTeams as $t) {
                            if ($t->getId() === $pt->getTeam())
                                $teamName = $t->getName();
                        }
                        ?>
                        <li><?= htmlspecialchars($teamName) ?> : <?= htmlspecialchars($pt->getRole()) ?></li>
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