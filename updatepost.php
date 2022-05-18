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
    <title>Bridge The Gap</title>
    <link rel="stylesheet" href="styles/reset.css"> 
    <link rel="stylesheet" href="styles/style.css"> 
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

        <div class="block2_update">
            <div>
            <form action="" method="POST" enctype="multipart/form-data">
            <h1 class="title">Update je post</h1>

                <div class="uploadForm">

                    <div class="inputPost">
                        <h2 class="title_medium" for="">Wil je de vraag aanpassen?</h2>
                        <input type="text" placeholder="Titel van je vraag" name="updateTitle" value="<?php echo htmlspecialchars($postData['title']); ?>" class="inputField inputTitle"><br>
                        <textarea class="inputField inputDescription" id="updateDescription" name="updateDescription" placeholder="Stel hier je vraag"><?php echo htmlspecialchars($postData['description']); ?></textarea>
                    </div>

                    <div class="addCategory">
                        <h2 class="title_medium">Wil je de categorie veranderen? </h2>
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
                    <input type="submit" class="button" name="update" value="Upload project">
                </div>

            </form>

            
            </div>
            
        </div>

        <div class="block3_update">
            <div class="block3_right updateRight">
                <h1 class="title">Afbeelding veranderen</h1>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="uploadPicture">
                        <h2 class="title_medium">Wil je de afbeelding veranderen?</h2>
                        <input type="file" id="postImage" name="postImage">
                    </div>
                    <?php if(isset($postData['img_path'])) : ?>
                        <div class="user__self">
                        <img class="postpicture_medium" src="images/postpictures/<?php echo $postData['img_path']; ?>" alt="Post picture">
                    
                        </div> 
                    <?php endif; ?>
                    <input type="submit" class="button" name="updatePostImage" value="Update post afbeelding">
                    
                </form>

                <div class="user_self">
                    <a class="button" href="deletepost.php?id=<?php echo $postData['id'] ?>"> Delete</a>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>