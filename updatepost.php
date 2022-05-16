<?php
require_once("bootstrap.php");
    session_start();
    if (isset($_SESSION['id'])) {
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    }

    $post = new Post();
    $postId = $_GET['id'];
    $postData = Post::getPost($postId);

    if(!empty($_POST['updatePostImage'])){
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
                                    $post->updatePostPicture($postPicture, $postId);

                                    header('location: updatepost.php?id='.$postId);

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
            $post->setTitle($_POST['updateTitle']);
            $post->setDescription($_POST['updateDescription']);
            $post->setPostId($postData['id']);

            if(isset($_POST['updateCategory'])) {
                $post->setCategory($_POST['updateCategory']); 
            }

            $post->updatePost();

            header('location: updatepost.php?id='.$postId);


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
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css"> 
</head>
<body>
<header>
        <?php include('nav.php'); ?>
    </header>

    <h1>Update je post</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label>Post picture</label>
            <input type="file" id="postImage" name="postImage">
        </div>
        <input type="submit" name="updatePostImage" value="Update post afbeelding">
        <?php if(isset($postData['img_path'])) : ?>
            <div class="user__self">
            <img class="postpicture_medium" src="images/postpictures/<?php echo $postData['img_path']; ?>" alt="Post picture">
        
            </div> 
        <?php endif; ?>
    </form>

    <form action="" method="POST" enctype="multipart/form-data">
        

        <div class="uploadForm">

            <div class="inputPost">
                <input type="text" placeholder="Titel van je vraag" name="updateTitle" value="<?php echo htmlspecialchars($postData['title']); ?>" class="inputField">
                <input type="text" placeholder="Stel hier je vraag" name="updateDescription" value="<?php echo htmlspecialchars($postData['description']); ?>" class="inputField">
            </div>

            <div>
                <label>Wil je je post een categorie geven? </label>
                    <div>
                        <input type="radio" name="updateCategory" value="Algemeen">
                        <label for="">Algemeen</label>
                    </div>
                    <div>
                        <input type="radio" name="updateCategory" value="Technologie">
                        <label for="">Technologie</label>
                    </div>
                    <div>
                        <input type="radio" name="updateCategory" value="Huishouden">
                        <label for="">Huishouden</label>
                    </div>
                    <div>
                        <input type="radio" name="updateCategory" value="Koken">
                        <label for="">Koken</label>
                    </div>
            </div>
            <input type="submit" class="postButton" name="update" value="Upload project">
        </div>

    </form>
</body>
</html>