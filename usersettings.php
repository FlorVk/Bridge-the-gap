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
    <link rel="stylesheet" href="styles/style.css"> 
</head>

<body>

<header>
        <?php include('nav.php');?>
</header>

<?php if (!empty($error)) {
        echo $error;
    } ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <div>
            <label>Profile picture</label>
            <img class="profilepicture_medium" src="images/profilepictures/<?php echo $userData['profilepicture']; ?>" alt="Profile picture">
            <input type="file" id="userImage" name="userImage" value=""><br>

        </div>
        <input type="submit" name="updateImage" value="Update profile picture">
    </form>

    <form action="" method="post" class="profile_info">
    <table class="profileTable">
        <tbody>
            <tr>
                <td> 
                    <label>First Name</label><br>
                    <input class="updateProfileInput" type="text" name="updateFirstName" value="<?php echo htmlspecialchars($userData['firstname']); ?>">
                </td>
                    <td><label>Last Name</label><br>
                    <input class="updateProfileInput" type="text" name="updateLastName" value="<?php echo htmlspecialchars($userData['lastname']); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email address</label><br>
                    <input class="updateProfileInput" type="email" name="updateEmail" value="<?php echo htmlspecialchars($userData['email']); ?>" readonly>
                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    <label>Bio</label><br>
                    <input class="updateProfileInput" type="text" style="height: 130px;" name="updateBio" value="<?php echo htmlspecialchars($userData['bio']); ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="updateProfileButton"type="submit" name="update" value="Update gegevens">
                </td>
            </tr>

                
        </tbody>
    </table>
       
</form>


</body>

</html>