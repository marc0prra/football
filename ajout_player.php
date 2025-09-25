<?php
include_once("includes/header.php");
include_once("index.php");
if ($METHOD == "POST"){
    $players[] = $_POST;
    if (!empty($players)){
        if (!empty($players["first_name"]) && !empty($players["last_name"]) && !empty($players["birthdate"]) && !empty($players["picture"])){
            
    } else {
        if (empty($players["first_name"])){
            $errors["first_name"] = "Veuillez renseigner le prénom";
        } else if (empty($players["last_name"])){
            $errors["last_name"] = "Veuillez renseigner le nom";
        } else if (empty($players["birthdate"])){
            $errors["birthdate"] = "Veuillez renseigner la date de naissance";
        } else if (empty($players["picture"])){
            $errors["picture"] = "Veuillez renseigner une image";
    }
         $errors["global"] = "Veuillez remplir tous les champs";
        }
}
}

?>

<form action="" method="post">
<label for="first_name">First Name:</label>
<input type="text" id="first_name" name="first_name" required><br>
<label for="last_name">Last Name:</label>
<input type="text" id="last_name" name="last_name" required><br>
<label for="birthdate">Birth date</label>
<input type="DateTime" id="birthdate" name="birthdate" required><br>
<label for="picture">Picture</label>
<input type="file" id="picture" name="picture" required><br>
<button type="submit">Add Player</button>

</form>

<?php
include_once("includes/footer.php");

?>