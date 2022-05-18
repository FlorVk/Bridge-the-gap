<?php

include_once("bootstrap.php");

session_start();

$sessionId = $_SESSION['id'];

$userData = User::getUserFromId($sessionId);

$firstName = $userData['firstname'];
$lastName = $userData['lastname'];
$fullname = $firstName . " " . $lastName;

$id = $_GET['id'];
$allPosts = Post::getPostsByUserId($id);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
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

        <div class="user_profile block2_index">
            <div class="user_profile">
                <div class="user_content ">
                    <div class="user_head posterContainer">
                        <img class="profilepicture_medium" src="./images/profilepictures/<?php echo $userData['profilepicture'] ?>" alt="">
                        <h1 class="poster_username post_username"><?php echo $fullname ?>
                        <p class="user_senior"><?php echo $userData['senior']; ?></p> </h1>
                    </div>

                    <div class="user__information">
                        <p class="user__bio"><?php echo $userData['bio']; ?></p>
                    </div>

                    <?php if($sessionId == $id) : ?>
                        <div class="user__self">
                            <a class="user__btn" href="usersettings.php"> Settings</a>
                            <a class="user__btn" href="logout.php">Logout</a>
                        </div> 
                    <?php endif; ?>
                </div>
                
                <div class="posts">
                    <?php foreach ($allPosts as $p) : ?>
                        <div class="post">
                                <div class="post_content">
                                    <a class="post_detail" href="detailPost.php?id=<?php echo $p['id'] ?>">

                                        <div class="post_content_box">
                                            <p><?php echo "Geupdate ".$p['time_posted']; ?></p>
                                            <p class="post_title"><?php echo $p['title']; ?></p>
                                            <p class="post_description"><?php echo $p['description']; ?></p>
                                        </div>

                                        <?php if(isset($p['img_path'])) : ?>
                                            <div class="post_content_image">
                                                <img class="postpicture_medium" src="images/postpictures/<?php echo $p['img_path']; ?>" alt="Post picture">
                                            </div> 
                                        <?php endif; ?>
                                    </a>
                                </div>
                        </div>
                    <?php endforeach; ?>
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