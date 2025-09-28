<?php
require_once "includes/database.php";

$sql = "
    SELECT 
        p.id AS player_id,
        p.fisrtname,
        p.lastname,
        DATE(p.birthdate) AS birthdate,
        t.name AS team_name,
        m.id AS match_id,
        m.date AS match_date,
        m.team_score,
        m.opponent_score,
        oc.city AS opponent_city
    FROM player p
    LEFT JOIN player_has_team pt ON p.id = pt.player_id 
    LEFT JOIN team t ON pt.team_id = t.id
    LEFT JOIN matchs m ON m.team_id = t.id
    LEFT JOIN opposing_club oc ON m.opposing_club_id = oc.id
    ORDER BY p.lastname, p.fisrtname, m.date
"; // LEFT JOIN car on affiche les joueurs qui ont un club mais pas de matchs


$stmt = $connexion->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// reorganise les données par joueur
$players = [];
foreach ($rows as $row) {
    $pid = $row['player_id'];
    if (!isset($players[$pid])) {
        $players[$pid] = [
            'fisrtname' => $row['fisrtname'],
            'lastname' => $row['lastname'],
            'birthdate' => $row['birthdate'],
            'team' => $row['team_name'],
            'matches' => []
        ];
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
            <h2><?= htmlspecialchars($player['fisrtname'] . " " . $player['lastname']) ?></h2>
            <p>Date de naissance : <?= htmlspecialchars($player['birthdate']) ?></p>
            <p>Club : <?= $player['team'] ? htmlspecialchars($player['team']) : "Aucun club" ?></p>


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
            <a href="edit_player.php?id=<?= urlencode($pid) ?>">Modifier</a>
        </div>
    <?php endforeach; ?>
</body>

</html>