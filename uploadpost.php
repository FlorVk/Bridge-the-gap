<?php
    require_once("bootstrap.php");

    session_start();
    if (isset($_SESSION['id'])) {
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    }

    if(!empty($_POST)){
        try {
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setDescription($_POST['description']);
            $post->setUserId($userData['id']);
            $post->setTimePosted(date("Y-m-d H:i:s"));

            if (isset($_FILES['postImage'])) {
                $imageName = $_FILES['postImage']['name'];
                $fileType  = $_FILES['postImage']['type'];
                $fileSize  = $_FILES['postImage']['size'];
                $fileTmpName = $_FILES['postImage']['tmp_name'];
                $fileError = $_FILES['postImage']['error'];

                $fileData = explode('/', $fileType);
                $fileExtension = $fileData[count($fileData)-1];

                if ($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png') {
                    //check if file is correct type
                    //check file size
                    try {
                        if ($fileSize < 5000000) {
                            $fileNewName = "images/postpictures/".basename($imageName);
                            $uploaded = move_uploaded_file($fileTmpName, $fileNewName);

                            try {
                                if ($uploaded) {
                                    $postPicture = basename($imageName);
                                    $post->setImage($postPicture);

                                    $post->uploadPost();
                                }
                            } catch (Exception $e) {
                                echo 'Er is iets misgelopen' . $e->getMessage();
                            }
                        }
                    } catch (Exception $e) {
                        echo 'Bestand te groot' . $e->getMessage();
                    }
                } else {
                    echo 'no';
                    $post->uploadPost();
                }
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridge the gap</title>
    <link rel="stylesheet" href="styles/style.css">  
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>

    <form action="" method="POST" enctype="multipart/form-data">
        

        <div class="uploadForm">
            <h1>Maak je post</h1>

            <div>
                <label>Post picture</label>
                <input type="file" id="postImage" name="postImage">
            </div>
            
            <div class="inputPost">
                <input type="text" placeholder="Titel van je vraag" name="title" value="" class="inputField">
                <input type="text" placeholder="Stel hier je vraag" name="description" value="" class="inputField">

                <input type="submit" class="postButton" value="Upload project">
            </div>
        </div>

    </form>
</body>
</html>