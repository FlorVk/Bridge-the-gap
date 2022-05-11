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
            //$id = $_SESSION['id'];
            //$userData = user::getUserFromId($id);

            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setDescription($_POST['description']);
            $post->setUserId($userData['id']);
            $post->setTimePosted(date("Y-m-d H:i:s"));

           
            $post->uploadPost();

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

    <form action="" method="POST">
        <div class="uploadForm">
            <h1>Maak je post</h1>
            <div class="inputPost">
                <input type="text" placeholder="Titel van je vraag" name="title" value="" class="inputField">
                <input type="text" placeholder="Stel hier je vraag" name="description" value="" class="inputField">

                <input type="submit" class="postButton" value="Upload project">
            </div>
        </div>

    </form>
</body>
</html>