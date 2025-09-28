<?php
require_once "includes/database.php";

$sql = "
    SELECT 
    p.id AS player_id,
    p.firstname,
    p.lastname,
    DATE(p.birthdate) AS birthdate,
    t.name AS team_name,
    pt.role AS player_role,
    m.id AS match_id,
    m.date AS match_date,
    m.team_score,
    m.opponent_score,
    oc.city AS opponent_city
FROM player p
LEFT JOIN player_has_team pt 
    ON p.id = pt.player_id
LEFT JOIN team t 
    ON pt.team_id = t.id
LEFT JOIN matchs m 
    ON m.team_id = t.id   -- un joueur peut avoir zéro match dans cette équipe
LEFT JOIN opposing_club oc 
    ON m.opposing_club_id = oc.id
ORDER BY p.lastname, p.firstname, t.name, m.date
"; // LEFT JOIN car on affiche les joueurs qui ont un club mais pas de matchs


$stmt = $connexion->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// reorganise les données par joueur
$players = [];
foreach ($rows as $row) {
    $pid = $row['player_id'];
    if (!isset($players[$pid])) {
        $players[$pid] = [
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'birthdate' => $row['birthdate'],
            'teams' => [],
            'matches' => [],
            'id' => $pid
        ];
    }

    if ($row['team_name']) {
        $teamKey = $row['team_name'] . ' - ' . $row['player_role']; // clé unique
        if (!isset($players[$pid]['teams'][$teamKey])) {
            $players[$pid]['teams'][$teamKey] = [
                'name' => $row['team_name'],
                'role' => $row['player_role']
            ];
        }
    }

    // ajoute le match uniquement si le joueur a un club et un match
    if ($row['match_id']) {
        $players[$pid]['matches'][] = [
            'date' => $row['match_date'],
            'score' => $row['team_score'] . " - " . $row['opponent_score'],
            'opponent' => $row['opponent_city']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>

<body>
    <h1>Infos des Joueurs</h1>
    <?php foreach ($players as $player): ?>
        <div class="player">
            <h2><?= htmlspecialchars($player['firstname'] . " " . $player['lastname']) ?></h2>
            <p>Date de naissance : <?= htmlspecialchars($player['birthdate']) ?></p>

            <?php if (!empty($player['teams'])): ?>
                <h3>Clubs :</h3>
                <ul>
                    <?php foreach ($player['teams'] as $team): ?>
                        <li>
                            <?= htmlspecialchars($team['name']) ?>
                            (Position : <?= htmlspecialchars($team['role']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Club : Aucun club</p>
            <?php endif; ?>

            <?php if (!empty($player['matches'])): ?>
                <h3>Matchs joués :</h3>
                <ul>
                    <?php foreach ($player['matches'] as $match): ?>
                        <li>
                            <?= htmlspecialchars($match['date']) ?> -
                            Score : <?= htmlspecialchars($match['score']) ?>
                            (vs <?= htmlspecialchars($match['opponent']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <a href="edit_player.php?id=<?= urlencode($player["id"]) ?>">Modifier</a>
        </div>
    <?php endforeach; ?>
</body>

</html>