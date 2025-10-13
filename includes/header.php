<?php if (!isset($_SESSION)) {
    session_start();
} ?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/php/football/includes/style.css?v=2" />
    <link rel="icon" href="img/MW_logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Epilogue:wght@100;200;300;400;500;600;700;800;900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>
<header>
    <div class="row gap5">
        <a href="/php/football/public/infos_player.php">Infos des joueurs</a>
        <a href="/php/football/public/crud/add_player.php">Nouveau joueur</a>
        <a href="/php/football/public/crud/add_team.php">Nouvelle équipe</a>
        <a href="/php/football/public/crud/add_opposing.php">Nouveau club adverse</a>
        <a href="/php/football/public/create_match.php">Nouveau match</a>
        <a href="/php/football/public/create_staff.php">Nouveau membre du staff</a>
    </div>

</header>