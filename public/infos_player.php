<?php
include("index.php");

use src\Model\DatabaseManager;
use src\Model\Team;

$db = new DatabaseManager($connexion);

$players = $db->selectPlayers();
$teams = Team::selectTeams();
$clubs = $db->selectClubs();

$playersWithMatch = [];
$playersWithoutMatch = [];

foreach ($players as $player) {
    $req = $connexion->prepare("SELECT team_id FROM player_has_team WHERE player_id = :pid");
    $req->execute([':pid' => $player->getId()]);
    $link = $req->fetch(PDO::FETCH_ASSOC);

    if ($link) {
        $teamId = $link['team_id'];

        $req2 = $connexion->prepare("SELECT COUNT(*) FROM matchs WHERE team_id = :tid");
        $req2->execute([':tid' => $teamId]);
        $nbMatchs = $req2->fetchColumn();

        if ($nbMatchs > 0) {
            $playersWithMatch[] = $player;
        } else {
            $playersWithoutMatch[] = $player;
        }
    } else {
        $playersWithoutMatch[] = $player;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher joueur</title>
    <link rel="stylesheet" href="includes/style.css?v=3">
</head>

<body>

    <h1>Infos des Joueurs</h1>

    <!-- SECTION : joueurs avec matchs -->
    <h2>Joueurs ayant joué des matchs</h2>
    <?php foreach ($playersWithMatch as $player): ?>
        <div class="player">
            <h2><?= htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?></h2>
            <p>Date de naissance :
                <?= htmlspecialchars($player->getBirthdate()->format('Y-m-d')) ?>
            </p>

            <?php
            // Affiche le club du joueur
            $teamName = "Aucun club";
        $teamId = null;
        foreach ($teams as $team) {
            $req = $connexion->prepare("SELECT team_id FROM player_has_team WHERE player_id = :pid");
            $req->execute([':pid' => $player->getId()]);
            $link = $req->fetch(PDO::FETCH_ASSOC);
            if ($link && $link['team_id'] == $team->getId()) {
                $teamName = $team->getName();
                $teamId = $team->getId();
                break;
            }
        }
        ?>
            <p>Club : <?= htmlspecialchars($teamName) ?></p>

            <?php
        // Affiche les matchs
        if ($teamId) {
            $matchs = $connexion->prepare("
                SELECT m.date, m.team_score, m.opponent_score, oc.city
                FROM matchs m
                LEFT JOIN opposing_club oc ON oc.id = m.opposing_club_id
                WHERE m.team_id = :tid
            ");
            $matchs->execute([':tid' => $teamId]);
            $listeMatchs = $matchs->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $listeMatchs = [];
        }
        ?>

            <?php if (!empty($listeMatchs)): ?>
                <h3>Matchs joués :</h3>
                <ul>
                    <?php foreach ($listeMatchs as $m): ?>
                        <li>
                            <?= htmlspecialchars($m['date']) ?> -
                            Score : <?= htmlspecialchars($m['team_score'] . " - " . $m['opponent_score']) ?>
                            (vs <?= htmlspecialchars($m['city']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <a href="edit_player.php?id=<?= urlencode($player->getId()) ?>">Modifier</a> |
            <a href="delete_player.php?id=<?= urlencode($player->getId()) ?>"
                onclick="return confirm('Supprimer ce joueur ?');">Supprimer</a>
        </div>
    <?php endforeach; ?>


    <!-- SECTION : joueurs sans matchs -->
    <h2>Autres joueurs</h2>
    <?php foreach ($playersWithoutMatch as $player): ?>
        <div class="player">
            <h2><?= htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?></h2>
            <p>Date de naissance :
                <?= htmlspecialchars($player->getBirthdate()->format('Y-m-d')) ?>
            </p>

            <?php
        // Affiche le club du joueur
        $teamName = "Aucun club";
        foreach ($teams as $team) {
            $req = $connexion->prepare("SELECT team_id FROM player_has_team WHERE player_id = :pid");
            $req->execute([':pid' => $player->getId()]);
            $link = $req->fetch(PDO::FETCH_ASSOC);
            if ($link && $link['team_id'] == $team->getId()) {
                $teamName = $team->getName();
                break;
            }
        }
        ?>
            <p>Club : <?= htmlspecialchars($teamName) ?></p>

            <a href="edit_player.php?id=<?= urlencode($player->getId()) ?>">Modifier</a> |
            <a href="delete_player.php?id=<?= urlencode($player->getId()) ?>"
                onclick="return confirm('Supprimer ce joueur ?');">Supprimer</a>
        </div>

        </div>
    <?php endforeach; ?>

</body>

</html>