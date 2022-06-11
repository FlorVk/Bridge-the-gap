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
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css">
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

        <div class="block2_update">
            <div class="usersettings_box">
                
            <h1 class="title">Pas je profiel aan</h1>
                <form action="" method="post" class="profile_info">
                            <div class="updateName">
                                <div> 
                                    <label>Voornaam</label><br>
                                    <input class="updateFirstName" type="text" name="updateFirstName" value="<?php echo htmlspecialchars($userData['firstname']); ?>">
                                </div>
                                <div>
                                    <label>Achternaam</label><br>
                                    <input class="updateProfileInput inputField" type="text" name="updateLastName" value="<?php echo htmlspecialchars($userData['lastname']); ?>">
                                </div>
                            </div>
                            <div>
                                <label>E-mail addres</label><br>
                                <input class="updateProfileInput inputField" type="email" name="updateEmail" value="<?php echo htmlspecialchars($userData['email']); ?>" readonly>
                            </div>
                            <div >
                                <label>Biografie</label><br>
                                <input class="updateProfileInput inputField inputDescription" type="text" name="updateBio" value="<?php echo htmlspecialchars($userData['bio']); ?>">
                            </div>

                            <div>
                                <div>
                                    <input type="radio" name="updateSenior" value="Senior">
                                    <label for="">Ik registreer me als 65-plusser</label>
                                </div>
                                <div>
                                    <input type="radio" name="updateSenior" value="Junior">
                                    <label for="">Ik ben geen 65-plusser</label>
                                </div>
                            </div>
                            
                            <input class="button" type="submit" name="update" value="Update je gegevens">
                </form> 
            </div>
        </div>

        <div class="block3_update">
            <div class="block3_right updateRight">
            <form action="" method="POST" enctype="multipart/form-data">
                    <h1 class="title">Verander je foto</h1>
                    <div class="uploadPicture">
                        <img class="profilepicture_large" src="images/profilepictures/<?php echo $userData['profilepicture']; ?>" alt="Profile picture">
                    </div>
                    <input type="file" id="userImage" name="userImage" value=""><br>
                    <input class="button" type="submit" name="updateImage" value="Update je profiel foto">
                </form>
            </div>
        </div>
        
    </div>

    


</body>

</html>