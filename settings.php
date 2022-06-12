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

?><!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update gegevens</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css">
</head>

<body>

<header>
        <?php include('nav.php');?>
</header>
    <div class="main">

        <div class="block1">
            <div class="block1_left">
                <?php include('nav_left.php'); ?>
            </div>
        </div>

        <div class="block2">
            <div class="usersettings_box">
                
            <h1 class="title">Account instellingen</h1>
                <div class="settings_container">
                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Profiel gegevens</h2>
                        <a class="btn_hollow_small" href="usersettings.php">Update je gegevens</a>
                    </div>
                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Wachtwoord</h2>
                        <a class="settings_link" href="usersettings.php">Wijzig je wachtwoord</a>
                    </div>

                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Profiel titel</h2>
                        <a class="settings_link" href="title.php">Verander je titel</a>
                    </div>

                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Logout</h2>
                        <a class="btn_hollow_small" href="logout.php">uitloggen op alle browsers</a>
                    </div>

                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Verwijder account</h2>
                        <a class="btn_hollow_small" href="deleteuser.php">Verwijder je account</a>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="block3">
            <div class="block3_right">
            
            </div>
        </div>
        
    </div>

    


</body>

</html>