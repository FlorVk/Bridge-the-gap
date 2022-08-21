<?php

include_once("bootstrap.php");

session_start();

$post = new Post;
$allPosts = $post->getAllTop();

$sessionId = 0;

if(isset($_SESSION['id'])){
    $sessionId = $_SESSION['id'];
    $user = User::getUserFromId($sessionId);
}





?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title> 
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
    
        <div class="posts block2_top">
            <div class="index_add index_top">
            <h1 class="title">Tips van de dag!</h1>
            <p>Dit bevelen andere aan:</p>

                
            </div>
            <div class="top_posts">
            <?php foreach ($allPosts as $p) : ?>
                <?php $allComments = Comment::getAll($p['id']); ?>
                <?php $allLikes = Like::getAll($p['id']); ?>
                <div class="top_post">
                <div class="post">
                        <div class="posterContainer">
                            <div class="poster_head">
                                <a href="user.php?id=<?php echo $p['user_id'] ?>" class="post_userinfo">
                                    <img class="profilepicture_small" src="./images/profilepictures/<?php echo $post->getUserByPostId($p['id'])['profilepicture'] ?>" alt="">
                                    <div class="post_username"><h1 class="username_title"><?php echo $post->getUserByPostId($p['id'])['firstname']?> <?php echo $post->getUserByPostId($p['id'])['lastname']?></h1>
                                </a>
                                    <p class="updated_when"><?php echo "Geüpdate ".$p['time_posted']; ?></p>
                                </div>
                            </div>
                            <div>
                                <?php if($sessionId == $p['user_id']) : ?>
                                    <div class="user_self">
                                        <a class="btn_hollow" href="updatepost.php?id=<?php echo $p['id']?>">...</a>
                                    </div> 
                                <?php endif; ?>
                            </div>
                        </div>
                        

                        <div class="post_content">
                            <a class="post_detail" href="detailpost.php?id=<?php echo $p['id'] ?>">

                            <div class="post_content_box">
                                
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
                <div class="post_bottom">
                <div class="likesContainer">
                            <div class="post_likes">
                                <?php
                                     if (Like::checkLiked($user['id'], $p['id']) == 2 ){
                                        echo '<input type="button" data-postid="'.$p['id'].'" class="btn_like" id="btnAddLike" name="like"  value=""/ >';
                                        }
                                    else {
                                        echo '<input type="button" data-postid="'.$p['id'].'" class="btn_unlike" id="btnAddUnlike" name="like"  value=""/ >';
                                        }
                                ?>

                                <div>
                                    <p class="likeCount"><?php echo count($allLikes); ?></p>
                                </div>
                            </div>
                            
                    </div>

                    <div class="post_tipped">
                                <?php
                                     if (Like::checkTipped($user['id'], $p['id']) == 2 ){
                                        echo '<input type="button" data-postid="'.$p['id'].'" class="btn_tip" id="btnAddTip" name="tip"  value="Tip van de dag"/ >';
                                        }
                                    else {
                                        echo '<input type="button" data-postid="'.$p['id'].'" class="btn_untip" id="btnAddUntip" name="tip"  value="Toch maar niet"/ >';
                                        }
                                ?>
                            </div>
                    <div>
                        <p class="countComments">Comments: <?php echo count($allComments); ?></p>
                    </div>
                </div>
                </div>
                
            <?php endforeach; ?>
            </div>
            

            <?php if(empty($allPosts)): ?>
                <div>
                    <h1 class="title no_posts">Er zijn nog geen posts in deze categorie!</h1>
                </div>
            <?php endif; ?>

            <?php if (!isset($_GET['search']) && !empty($allPosts)) : ?>
                <p class="links_title">Zie meer posts:</p>
            <div class="pages">
                <?php for ($pages = 1; $pages <= $total_pages; $pages++) : ?>
                    <a href='<?php echo "?page=$pages"; ?>' class="links"><?php echo $pages; ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            

        </div>

        

    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="ajax/index.js"></script>
    
</body>
</html>