<?php

include_once("bootstrap.php");

session_start();
if (isset($_SESSION['id']) && !empty($_POST['password'])) {
    try {
        $sessionId = $_SESSION['id'];
        $password = $_POST["password"];
        User::deleteUser($sessionId, $password);
        session_destroy();
        header("Location: register.php");
    } catch (Throwable $error) {
        $error = $error->getMessage();
    }
} else {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridge the gap</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css">
</head>

<body>
    <div class="main_login">
        <div class="block1">
            <div class="img_box">
                <img class="image_login" src="./images/components/login.png" alt="">
            </div>
        </div>

        <div class="block2_login">
            <form class="form_login" action="" method="post">
                <h1 class="title">Ben je zeker dat je het account wilt verwijderen?</h1>
                <label>Mijn wachtwoord</label>
                <input type="password" name="password" class="inputField login_field"><br>

                <?php if (isset($error)) {
                    echo "<div class='error' id='error'>" . $error . "</div>";
                } ?>
                <button class="button" type="submit">Verwijder account</button>
                <a class="btn_hollow" href="settings.php">Account niet verwijderen</a>
            </form>
        </div>
    </div>
    