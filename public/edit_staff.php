<?php
use src\Model\DatabaseManager;
use src\Model\StaffMember;
use src\Model\Team;

include_once("index.php");

// --- Vérification de l'ID ---
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // --- Récupération du membre du staff ---
    $staff = StaffMember::selectTargetStaff($staff_id);


    // --- Récupération de toutes les équipes ---
    $allTeams = Team::selectTeams();
}

// --- Liste des rôles possibles ---
$roles = ["Entraîneur principal", "Adjoint", "Préparateur physique", "Médecin", "Analyste vidéo"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $infos = DatabaseManager::returnArray($_POST);

    if (!isset($infos["errors"])) {

        // --- Modifier les infos du staff ---
        if (isset($infos["firstname"])) {
            $staffPost = new StaffMember(
                $infos["firstname"],
                $infos["lastname"],
                "",
                $infos["role"],
                $staff_id
            );


            StaffMember::updateStaff($staffPost, $staff_id);

            $_SESSION['staff'] = "Le membre du staff a bien été modifié !";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $staff_id);
            exit;
        }
    }
}
?>

<body>
    <div class="row gap6">
        <div>
            <h1>Modifier le membre du staff</h1>

            <?php if (isset($_SESSION['staff'])): ?>
                <div class="success"><?= $_SESSION['staff'];
                unset($_SESSION['staff']); ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Prénom :</label><br>
                <input type="text" name="firstname" value="<?= htmlspecialchars($staff->getFirstname()) ?>"
                    required><br><br>

                <label>Nom :</label><br>
                <input type="text" name="lastname" value="<?= htmlspecialchars($staff->getLastname()) ?>"
                    required><br><br>

                <label>Photo :</label><br>
                <input type="text" name="picture" value="<?= htmlspecialchars($staff->getPicture()) ?>"><br><br>

                <label>Rôle :</label><br>
                <select name="role">
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= htmlspecialchars($r) ?>" <?= ($staff->getRole() === $r) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <button type="submit">Modifier</button>
            </form>
        </div>

        <div>
            <h1>Assigner à une équipe</h1>

            <?php if (isset($_SESSION['equipe'])): ?>
                <div class="success"><?= $_SESSION['equipe'];
                unset($_SESSION['equipe']); ?></div>
            <?php endif; ?>

            <?php if (!empty($theTeamsName)): ?>
                <ul>
                    <?php foreach ($theTeamsName as $team): ?>
                        <li><?= htmlspecialchars($team->getTeamName()) ?> : <?= htmlspecialchars($team->getRole()) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Ce membre n’est associé à aucune équipe.</p>
            <?php endif; ?>

            <form method="post">
                <label>Équipe :</label><br>
                <select name="équipe">
                    <?php foreach ($allTeams as $t): ?>
                        <option value="<?= $t->getId() ?>"><?= htmlspecialchars($t->getName()) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Rôle dans l’équipe :</label><br>
                <select name="role_assign">
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= htmlspecialchars($r) ?>"><?= htmlspecialchars($r) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="hidden" name="staff" value="<?= $staff->getId() ?>">
                <button type="submit">Assigner</button>
            </form>
        </div>
    </div>
</body>

</html>