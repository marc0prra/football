<?php
session_start();

use src\Model\DatabaseManager;
include_once("index.php");

$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (empty($id)) {
    $_SESSION['error'] = "Aucun identifiant de membre du staff fourni.";
    header("Location: afficher_staff.php");
    exit;
}

$dbManager = new DatabaseManager($connexion);
$dbManager->deleteStaff((int) $id);

$_SESSION['success'] = "Le membre du staff a été supprimé avec succès.";
header("Location: create_staff.php");
exit;
