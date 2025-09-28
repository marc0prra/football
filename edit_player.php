<?php
include_once("includes/header.php");
include_once("index.php");
// Vérifier qu'on est en POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {


}
?>

<form action="" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br>
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="birthdate">Birth date</label>
    <input type="Date" id="birthdate" name="birthdate" required><br>
    <label for="picture">Picture</label>
    <input type="text" id="picture" name="picture" required><br>
    <button type="submit">Add Player</button>

</form>