<?php
require_once "includes/database.php";

if (!isset($_GET['id'])) {
    die("ID manquant");
}

$id = (int) $_GET['id'];

// on supp les liens du joueur 
$connexion->prepare("DELETE FROM player_has_team WHERE player_id = ?")->execute([$id]);

// apres on supp le joueur grace a l'id
$connexion->prepare("DELETE FROM player WHERE id = ?")->execute([$id]);

header("Location: infos_player.php");
exit;
