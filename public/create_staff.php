<?php
include("index.php");

use src\Model\DatabaseManager;
use src\Model\StaffMember;
use src\Model\Team;

$db = new DatabaseManager($connexion);
$staffMembers = $db->selectStaffMembers();

// Ajouter un membre du staff
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $role = trim($_POST['role']);

    if ($firstname && $lastname && $role) {
        $stmt = $connexion->prepare("
            INSERT INTO staff_member (first_name, last_name, role)
            VALUES (:firstname, :lastname, :role)
        ");
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':role' => $role
        ]);

        $_SESSION['success'] = "Le membre du staff a été ajouté avec succès !";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher le staff</title>
    <link rel="stylesheet" href="includes/style.css?v=3">
</head>

<body>

    <h1>Infos du Staff</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?= $_SESSION['success'];
        unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error'];
        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (empty($staffMembers)): ?>
        <p>Aucun membre du staff n’a encore été ajouté.</p>
    <?php else: ?>
        <div class="staff-container">
            <?php foreach ($staffMembers as $staff): ?>
                <div class="staff">
                    <h2><?= htmlspecialchars($staff->getFirstname() . " " . $staff->getLastname()) ?></h2>
                    <p><strong>Rôle :</strong> <?= htmlspecialchars($staff->getRole()) ?></p>

                    <!-- Liens d’action -->
                    <a href="edit_staff.php?id=<?= urlencode($staff->getId()) ?>">Modifier</a> |
                    <a href="delete_staff.php?id=<?= urlencode($staff->getId()) ?>"
                        onclick="return confirm('Supprimer ce membre du staff ?');">Supprimer</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Ajouter un membre du staff</h2>
    <form action="" method="post" enctype="multipart/form-data" class="add-form">
        <label>Prénom :</label><br>
        <input type="text" name="firstname" required><br><br>

        <label>Nom :</label><br>
        <input type="text" name="lastname" required><br><br>

        <label>Rôle :</label><br>
        <select name="role" required>
            <option value="">Choisir un rôle </option>
            <option value="Entraîneur principal">Entraîneur principal</option>
            <option value="Adjoint">Adjoint</option>
            <option value="Préparateur physique">Préparateur physique</option>
            <option value="Médecin">Médecin</option>
            <option value="Analyste vidéo">Analyste vidéo</option>
        </select><br><br>

        <button type="submit">Ajouter</button>
    </form>

</body>

</html>