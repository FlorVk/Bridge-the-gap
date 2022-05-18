<?php

include_once("bootstrap.php");

session_start();

$postId = $_GET['id'];

$postData = Post::getPost($postId);

$sessionId = $_SESSION['id'];

$userData = User::getUserFromId($sessionId);

$id = $postData['user_id'];



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
    <title>Post</title>
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

        <div class="postContainer block2">
            <div class="detail_box">
                <div class="detail_container">
                   <div class="posterContainer">
                       <div class="poster_head">
                            <a href="user.php?id=<?php echo $postData['user_id'] ?>" class="post_userinfo">
                                <img class="profilepicture_medium" src="./images/profilepictures/<?php echo $posterUserData['profilepicture'] ?>" alt="">
                                <h1 class="post_username"><?php echo $fullnamePoster ?>
                            </a>
                                    <p><?php echo "Geupdate ".$postData['time_posted']; ?></p>
                                </h1>
                       </div>

                       <div>
                            <?php if($sessionId == $id) : ?>
                                <div class="user_self">
                                    <a class="btn_hollow" href="updatepost.php?id=<?php echo $postData['id']?>">Update post</a>
                                </div> 
                            <?php endif; ?>
                       </div>
                        

                        
                    </div> 

                    <div class="postImgContainer">
                        <p class="post_title"><?php echo $postData['title']; ?></p>
                        <p class="post_description"><?php echo $postData['description']; ?></p>

                        <?php if(isset($postData['img_path'])) : ?>
                            <div class="post_content_image">
                                <img class="postpicture_large" src="images/postpictures/<?php echo $postData['img_path']; ?>" alt="Post picture">
                            </div> 
                        <?php endif; ?>
                            
                        
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