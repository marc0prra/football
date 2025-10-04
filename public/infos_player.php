<?php

use src\Model\OpposingClub;
use src\Model\Player;
use src\Model\PlayerHasTeam;
require_once "index.php";

// Récupération des objets
$players = Player::selectPlayers();
$teams = PlayerHasTeam::selectTeams();
$clubs = OpposingClub::selectClubs();
?>

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
<?php
require_once(__DIR__ . '/../includes/footer.php');
?>
