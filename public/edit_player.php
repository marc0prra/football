<?php
include_once("index.php");
use src\Model\Player;
use src\Model\PlayerHasTeam;
// --- Connexion BDD ---
$pdo = new PDO("mysql:host=localhost;dbname=football;charset=utf8mb4", "root", "");

// --- Vérification de l'ID ---
if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    $requeteSelection = $connexion->prepare(
        'SELECT * FROM player
            WHERE id = :id'
    );
    $requeteSelection->bindParam('id', $player_id);
    $requeteSelection->execute();
    $getThePlayer = $requeteSelection->fetchAll(PDO::FETCH_ASSOC);

    $player = new Player(
        $getThePlayer[0]["firstname"],
        $getThePlayer[0]["lastname"],
        new DateTime($getThePlayer[0]["birthdate"]),
        $getThePlayer[0]["picture"],
        $getThePlayer[0]["id"]
    );


    $requeteSelectTeam = $connexion->prepare('SELECT * FROM player_has_team WHERE player_id = :id');
    $requeteSelectTeam->bindParam('id', $player_id);
    $requeteSelectTeam->execute();
    $theTeams = $requeteSelectTeam->fetchAll(PDO::FETCH_ASSOC);

    $counter = 1;
    $players = [];
    foreach ($theTeams as $theTeam) {
        $players[$counter] = new PlayerHasTeam(
            $theTeam["player_id"],
            $theTeam["team_id"],
            $theTeam["role"]
        );

        $requeteSelectNameTeam = $connexion->prepare('SELECT `name` FROM team WHERE id = :id');
        $requeteSelectNameTeam->bindParam('id', $theTeam["team_id"]);
        $requeteSelectNameTeam->execute();
        $theNameTeam[] = $requeteSelectNameTeam->fetch(PDO::FETCH_ASSOC);
    }
}



$requeteSelectNameTeam = $connexion->prepare('SELECT * FROM team ORDER BY `name`');
$requeteSelectNameTeam->execute();
$teams = $requeteSelectNameTeam->fetchAll(PDO::FETCH_ASSOC);

$types = ["Attaquant", "Milieu", "Défenseur", "Gardien"];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        if (isset($infos["firstname"])) {
            $playerPost = new Player(
                $infos["firstname"],
                $infos["lastname"],
                new DateTime($infos["birthdate"]),
                $infos["picture"]
            );

            $firstName = $playerPost->getFirstname();
            $lastName = $playerPost->getLastname();
            $birthDate = $playerPost->getBirthdate()->format('Y-m-d H:i:s');
            $picture = $playerPost->getPicture();

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

        } elseif (isset($infos["joueur"])) {
            $team = new PlayerHasTeam(
                $infos["joueur"],
                $infos["équipe"],
                $infos["position"]
            );
            $idJoueur = $team->getPlayer();
            $idTeam = $team->getTeam();
            $positionJoueur = $team->getRole();

            var_dump($positionJoueur);

            $insertHasTeam = $connexion->prepare(
                'INSERT INTO player_has_team (player_id, team_id, `role`) VALUES (:pid, :tid, :pos)'
            );
            $insertHasTeam->bindParam('pid', $idJoueur);
            $insertHasTeam->bindParam('tid', $idTeam);
            $insertHasTeam->bindParam('pos', $positionJoueur);
            $insertHasTeam->execute();
            $_SESSION['equipe'] = "Le joueur a bien été assigné à une équipe !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $player_id);
            exit;
        }

    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Modifier joueur</title>
</head>

<body>
    <div class="row gap5">
        <div>
            <h1>Modifier le joueur</h1>
            <?php if (isset($_SESSION['joueur'])): ?>
                <div class="success">
                    <?php
                    echo $_SESSION['joueur'];
                    unset($_SESSION['joueur']);
                    ?>
                </div>
            <?php endif; ?>


            <form method="post">
                <label>Prénom :</label><br>
                <input type="text" name="firstname"
                    value="<?= isset($playerPost) ? $playerPost->getFirstname() : htmlspecialchars($player->getFirstname()) ?>"
                    required><br><br>

                <label>Nom :</label><br>
                <input type="text" name="lastname"
                    value="<?= isset($playerPost) ? $playerPost->getLastname() : htmlspecialchars($player->getLastname()) ?>"
                    required><br><br>

                <label>Date de naissance :</label><br>
                <input type="date" name="birthdate"
                    value="<?= isset($playerPost) ? $playerPost->getBirthdate()->format('Y-m-d') : htmlspecialchars($player->getBirthdate()->format('Y-m-d')) ?>"
                    required>
                <br><br>

                <label>Photo :</label><br>
                <input type="text" name="picture"
                    value="<?= isset($playerPost) ? $playerPost->getPicture() : htmlspecialchars($player->getPicture()) ?>"><br><br>

                <button type="submit">Modifier</button>
            </form>
        </div>
        <!---Formulaire d'association à une équipe------>
        <div>
            <h1>Ajouter le joueur dans une équipe</h1>
            <?php if (isset($_SESSION['equipe'])): ?>
                <div class="success">
                    <?php
                    echo $_SESSION['equipe'];
                    unset($_SESSION['equipe']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($theTeams) && !empty($theNameTeam)): ?>
                <ul>
                    <?php foreach ($theTeams as $index => $theTeam): ?>
                        <li><?= htmlspecialchars($theNameTeam[$index]["name"]) ?> : <?= htmlspecialchars($theTeam["role"]) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Le joueur n'est associé à aucun club pour le moment.</p>
            <?php endif; ?>


            <form action="" method="post">
                <p class="error"><?php echo isset($infos["errors"]["joueur"]) ? $infos["errors"]["joueur"] : "" ?></p>
                <select name="joueur" id="joueur">
                    <option value="<?= htmlspecialchars($player->getId()) ?>">
                        <?=
                            isset($playerPost)
                            ? $playerPost->getFirstname() . " " . $playerPost->getLastname()
                            : htmlspecialchars($player->getFirstname() . " " . $player->getLastname()) ?>
                    </option>
                </select><br><br>

                <p class="error"><?php echo isset($infos["errors"]["équipe"]) ? $infos["errors"]["équipe"] : "" ?></p>
                <label for="select-team">Choisissez une équipe</label><br>
                <select name="équipe" id="équipe">
                    <?php foreach ($teams as $team) { ?>
                        <option value="<?= htmlspecialchars($team["id"]) ?>">
                            <?= htmlspecialchars($team["name"]) ?>
                        </option>
                    <?php } ?>
                </select><br><br>

                <p class="error"><?php echo isset($infos["errors"]["position"]) ? $infos["errors"]["position"] : "" ?>
                </p>
                <label for="select-type">Choisissez une position pour le joueur</label><br>
                <select name="position" id="position">
                    <?php foreach ($types as $type) { ?>
                        <option value="<?= htmlspecialchars($type) ?>">
                            <?= htmlspecialchars($type) ?>
                        </option>
                    <?php } ?>
                </select><br><br>

                <button type="submit">Ajouter à l'équipe</button>
            </form>
        </div>
    </div>
</body>

</html>
<?php
require_once(__DIR__ . '/../includes/footer.php');
?>
