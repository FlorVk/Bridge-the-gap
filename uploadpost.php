<?php
    require_once("bootstrap.php");
    session_start();
    if (isset($_SESSION['id'])) {
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    } else {
        header('location: login.php');
    }

    $category2 = $_GET['category'];

    switch ($category2) {
        case "Oplossing":
            $title = "Wat is je oplossing op iets?";
            $category = "oplossing" ;
            break;
        case "Vraag":
            $title = "Wat is je vraag?";
            $category = "vraag" ;
            break;
        case "Bericht":
            $title = "Wat wil je plaatsen?";
            $category = "bericht" ;
            break;
        case "":
            $title = "Wat is je vraag?";
            $category = "vraag" ;
            break;
    }

    

    if(!empty($_POST)){
        try {
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setDescription($_POST['description']);
            $post->setUserId($userData['id']);
            $post->setTimePosted(date("Y-m-d H:i:s"));
            $post->setCategory2($_GET['category']); 

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

            if(isset($_POST['category'])) {
                $post->setCategory($_POST['category']); 
            }
            
            $post->uploadPost();

        } catch (Throwable $error){
            $error = $error->getMessage();
        }
        
    }
    
?><!DOCTYPE html>
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
    <header>
        <?php include('nav.php'); ?>
    </header>

    <div class="main">
        <div class="block1">
            <div class="block1_left">
                <?php include('nav_left.php'); ?>
            </div>
        </div>

        <div class="block2">
            <form action="" method="POST" enctype="multipart/form-data">
            

            <div class="uploadForm">
                <h1 class="title">Maak je post</h1>

                <div>
                <?php if (isset($error)) {
                    echo "<div class='error' id='error'>" . $error . "</div>";
                } ?>
                </div>
                
                <div class="inputPost">
                    <h2 class="title_medium" for=""><?php echo $title?></h2>
                    <input type="text" placeholder="Titel van je vraag" name="title" value="" class="inputField inputTitle"><br>
                    <?php 
                        if(isset($_GET['vraag'])){
                            $vraag = $_GET['vraag'];
                            echo "<textarea class='inputField inputDescription' id='description' name='description' placeholder='Stel hier je vraag'>$vraag</textarea>";
                        }
                        else {
                            echo "<textarea class='inputField inputDescription' id='description' name='description' placeholder='Stel hier je vraag'></textarea>";
                        }
                    ?>
                    
                    </div>

                <div class="uploadPicture">
                    <h2 class="title_medium">Kies een optionele foto</h2>
                    <input type="file" id="postImage" name="postImage">
                </div>

                <div class="addCategory">
                    <h2 class="title_medium">Wil je je <?php echo $category ?> een categorie geven? </h2>
                        <div>
                            <input type="radio" name="category" value="Algemeen">
                            <label for="">Algemeen</label>
                        </div>
                        <div>
                            <input type="radio" name="category" value="Technologie">
                            <label for="">Technologie</label>
                        </div>
                        <div>
                            <input type="radio" name="category" value="Huishouden">
                            <label for="">Huishouden</label>
                        </div>
                        <div>
                            <input type="radio" name="category" value="Koken">
                            <label for="">Koken</label>
                        </div>
                </div>
                <input type="submit" class="button" value="Stel je vraag">
            </div>

            </form>
        </div>

        <div class="block3">
            <div class="block3_right">

            </div>
        </div>

    </div>

    
</body>
</html>