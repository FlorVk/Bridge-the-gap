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

    if (!empty($_POST['updateImage'])) {
        $imageName = $_FILES['userImage']['name'];
        $fileType  = $_FILES['userImage']['type'];
        $fileSize  = $_FILES['userImage']['size'];
        $fileTmpName = $_FILES['userImage']['tmp_name'];
        $fileError = $_FILES['userImage']['error'];

        $fileData = explode('/', $fileType);
        $fileExtension = $fileData[count($fileData)-1];

        if ($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png') {
            //check if file is correct type
            //check file size
            try {
                if ($fileSize < 5000000) {
                    $fileNewName = "images/profilepictures/".basename($imageName);
                    $uploaded = move_uploaded_file($fileTmpName, $fileNewName);

                    try {
                        if ($uploaded) {
                            $profilePicture = basename($imageName);
                            $user->setProfilePicture($profilePicture);
                            $user->updateProfilePicture($profilePicture, $sessionId);
                        }
                    } catch (Exception $e) {
                        echo 'Er is iets misgelopen' . $e->getMessage();
                    }
                }
            } catch (Exception $e) {
                echo 'Bestand te groot' . $e->getMessage();
            }
        }
    }


    if (!empty($_POST['update'])) {
        try {
            $user->setFirstName($_POST['updateFirstName']);
            $user->setLastname($_POST['updateLastName']);
            $user->setEmail($_POST['updateEmail']);
            $user->setBio($_POST['updateBio']);
            $user->setUserId($userData['id']);

            if(isset($_POST['updateSenior'])) {
                $user->setSenior($_POST['updateSenior']); 
            }

            $user->updateUser();

            header('location: usersettings.php');

        } catch (Throwable $error) {
            $error = $error->getMessage();
        }
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
</head>

<body>

<header>
        <?php include('nav.php');?>
</header>

<?php if (!empty($error)) {
        echo $error;
    } ?>

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
                        <a class="btn_hollow" href="usersettings.php">Update je gegevens</a>
                    </div>
                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Wachtwoord</h2>
                        <a href="usersettings.php">Wijzig je wachtwoord</a>
                    </div>

                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Login beveiliging</h2>
                        <a href="usersettings.php">Vereis email comfirmatie</a>
                    </div>

                    <div class="settings_item">
                        <h2 class="title_appleBlue_settings">Logout</h2>
                        <a class="btn_hollow" href="logout.php">uitloggen op alle browsers</a>
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