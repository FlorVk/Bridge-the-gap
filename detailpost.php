<?php

include_once("bootstrap.php");

session_start();

$postId = $_GET['id'];

$postData = Post::getPost($postId);



$posterUserData = Post::getUserByPostId($postId);
$firstNamePoster = $posterUserData['firstname'];
$lastNamePoster = $posterUserData['lastname'];
$fullnamePoster = $firstNamePoster . " " . $lastNamePoster;



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles/style.css">  
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>

    <div class="postContainer">
        <div class="posterContainer">
            <img class="profilepicture_medium" src="./images/profilepictures/<?php echo $posterUserData['profilepicture'] ?>" alt="">
            <h1 class="poster_username"><?php echo $fullnamePoster ?></p>
        </div>

        <div class="postImgContainer">
            <img class="postImg" src="<?php echo $postPicture ?>" alt="">
            <p><?php echo "Geupdate ".$postData['time_posted']; ?></p>
            <p><?php echo $postData['title']; ?></p>
            <p><?php echo $postData['description']; ?></p>
        </div>


</body>
</html>