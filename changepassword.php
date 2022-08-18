<?php

include_once("bootstrap.php");

session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login.php');
    } else{
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    }

    if (!empty($_POST)) {
        try {
            $currentpassword = $_POST["currentpassword"];
            $newpassword = $_POST["newpassword"];
            $newpassword2 = $_POST["newpassword2"];
    
            $sessionId = $_SESSION['id'];
            $user = User::getUserFromId($sessionId);
            $id = $user["id"];
    
    
            if ($newpassword === $newpassword2) {
                User::changeCurrentPassword($currentpassword, $newpassword, $newpassword2, $id);
                header("location: index.php");
            } else {
                throw new Exception("Passwords dont match each other");
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

$sessionId = $_SESSION['id'];

$userData = User::getUserFromId($sessionId);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
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

                <h1 class="title_big">Verander je wachtwoord</h1>

                <div class="login_input">
                    <label>Huidig wachtwoord</label><br>
                    <input class="inputField login_field" type="password" name="currentpassword" class="inputfield"><br>

                    <label> Nieuw wachtwoord</label><br>
                    <input class="inputField login_field" type="password" name="newpassword" class="inputfield"><br>

                    <label> Herhaal wachtwoord</label><br>
                    <input class="inputField login_field" type="password" name="newpassword2" class="inputfield"><br>
                </div>
                

                <?php if (isset($error)) {
                    echo "<div class='error' id='error'>" . $error . "</div>";
                } ?>

                <button class="button" type="submit">Verander je wachtwoord!</button>
            </form>
        </div>
    </div>

</body>
</html>