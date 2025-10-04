<?php
session_start();
include_once("./index.php");
use src\Model\OpposingClub;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $infos = returnArray($_POST);
    if (!isset($infos["errors"])) {
        $opposingClub = new OpposingClub(
            $infos["adresse"],
            $infos["ville"],
        );
        $opposingClub->insertClub();
        $infos = "";
        $_SESSION['success'] = "Le club opposé a bien été ajouté !";
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
    <title>Ajouter un équipe opposante</title>
</head>

<form action="" method="post">
    <p class="error">
        <?php echo isset($infos["errors"]["ville"]) ? $infos["errors"]["ville"] : "" ?>
    </p>
    <label for="ville">Nom de la ville* :</label>
    <input type="text" id="ville" name="ville" required><br>

    <p class="error"><?php echo isset($infos["errors"]["adresse"]) ? $infos["errors"]["adresse"] : "" ?></p>
    <label for="adresse" placeholder="includes/images/">Adresse* : </label>
    <input type="text" id="adresse" name="adresse" required><br><br>

    <button type="submit">Créer équipe opposé</button>

</form>

<?php
require_once(__DIR__ . '/../../includes/footer.php');
?>
