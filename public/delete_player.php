<?php

session_start();

use src\Model\DatabaseManager;

include_once("index.php");

$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (empty($id)) {
    $_SESSION['error'] = "Aucun identifiant de joueur fourni.";
    header("Location: infos_player.php");
    exit;
}

$dbManager = new DatabaseManager($connexion);
$dbManager->deletePlayer((int) $id);

$_SESSION['success'] = "Le joueur a été supprimé.";
header("Location: infos_player.php");
exit;
