<?php
require_once "includes/database.php";
require_once "index.php";   // contient les fonctions selectPlayers / selectTeams / selectClubs
require_once "includes/functions.php";

// Récupération des objets
$players = selectPlayers();
$teams = selectTeams();
$clubs = selectClubs();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Infos joueurs</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@100..900&family=Inter:wght@100..900&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <h1>Infos des Joueurs</h1>

    <?php foreach ($players as $player): ?>
        <div class="player">
            <h2><?= htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?></h2>
            <p>Date de naissance :
                <?= htmlspecialchars($player->getBirthdate()->format('Y-m-d')) ?>
            </p>


            <?php
            // Trouver l’équipe (si elle existe) : on cherche le team_id dans player_has_team
            $teamName = "Aucun club";
            foreach ($teams as $team) {
                // On suppose que Player a un getId() et qu’il y a une table player_has_team
                $req = $connexion->prepare(
                    "SELECT team_id FROM player_has_team WHERE player_id = :pid"
                );
                $req->execute([':pid' => $player->getId()]);
                $link = $req->fetch(PDO::FETCH_ASSOC);
                if ($link && $link['team_id'] == $team->getId()) {
                    $teamName = $team->getName();
                    break;
                }
            }
            ?>
            <p>Club : <?= htmlspecialchars($teamName) ?></p>

            <?php
            // Afficher les matchs de l'équipe du joueur
            if ($teamName !== "Aucun club") {
                $matchs = $connexion->prepare(
                    "SELECT m.date, m.team_score, m.opponent_score, oc.city
                 FROM matchs m
                 LEFT JOIN opposing_club oc ON oc.id = m.opposing_club_id
                 WHERE m.team_id = :tid"
                );
                $matchs->execute([':tid' => $team->getId()]);
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

</body>

</html>