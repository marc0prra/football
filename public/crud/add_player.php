<?php
include_once("../index.php");
use src\Model\DatabaseManager;
use src\Model\Player;
// Vérifier qu'on est en POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = DatabaseManager::returnArray($_POST);
    if (!isset($infos["errors"])) {
        //Tout les champs sont remplis ? On peut insérer en BDD
        $player = new Player(
            $infos["prenom"],
            $infos["nom_de_famille"],
            $infos["date_de_naissance"],
            $infos["photo"]
        );

        $dbManager = new DatabaseManager($connexion);
        $dbManager->insertPlayer($player);
        $infos = "";
        $_SESSION['success'] = "Le joueur a bien été ajouté !";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="success">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un joueur</title>
</head>

<form action="" method="post">
    <p class="error"><?php echo isset($infos["errors"]["prenom"]) ? $infos["errors"]["prenom"] : "" ?></p>
    <label for="prenom">Prénom* :</label>
    <input type="text" id="prenom" name="prenom" required><br>

    <p class="error"><?php echo isset($infos["errors"]["nom_de_famille"]) ? $infos["errors"]["nom_de_famille"] : "" ?>
    </p>
    <label for="nom_de_famille">nom de famille* :</label>
    <input type="text" id="nom_de_famille" name="nom_de_famille" required><br>

    <p class="error">
        <?php echo isset($infos["errors"]["date_de_naissance"]) ? $infos["errors"]["date_de_naissance"] : "" ?>
    </p>
    <label for="date_de_naissance">Date de naissance* :</label>
    <input type="date" id="date_de_naissance" name="date_de_naissance" required><br>

    <p class="error"><?php echo isset($infos["errors"]["photo"]) ? $infos["errors"]["photo"] : "" ?></p>
    <label for="photo" placeholder="includes/images/">Photo* </label>
    <input type="text" id="photo" name="photo" required><br><br>

    <button type="submit">Ajouter joueur</button>

</form>

<?php
require_once(__DIR__ . '/../../includes/footer.php');
?>