<?php
session_start();

use src\Model\DatabaseManager;
include_once("index.php");

if (!isset($connexion)) {
    die("Erreur : connexion à la base non initialisée.");
}

$id = null;
if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if (empty($id)) {
    $_SESSION['error'] = "Aucun identifiant de joueur fourni.";
    header("Location: infos_player.php");
    exit;
}

try {
    $dbManager = new DatabaseManager($connexion);

    $stmt = $connexion->prepare('DELETE FROM player_has_team WHERE player_id = :id');
    $stmt->execute(['id' => $id]);

    $stmt2 = $connexion->prepare('DELETE FROM player WHERE id = :id');
    $stmt2->execute(['id' => $id]);

    if ($stmt2->rowCount() > 0) {
        $_SESSION['success'] = "Le joueur (ID: $id) a bien été supprimé.";
    } else {
        $_SESSION['error'] = "Aucun joueur trouvé avec l'ID $id.";
    }

    header("Location: infos_player.php");
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
    header("Location: infos_player.php");
    exit;
}
