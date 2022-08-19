<?php

include_once("bootstrap.php");

session_start();

if (isset($_GET['search'])) {
    $post = new Post;
    $allPosts = $post->getAllPostsLimitFiltered($_GET['search']);
} else {
    $post = new Post;
    $allPosts = $post->getAllPostsLimit();
}

if (isset($_GET['category'])) {
    $post = new Post;
    $allPosts = $post->getAllPostsLimitCategory($_GET['category']); 
}

if (isset($_GET['category2'])) {
    $post = new Post;
    $allPosts = $post->getAllPostsLimitCategory($_GET['category2']); 
}

if (isset($_GET['category']) && $_GET['category'] === 'Alles') {
    $post = new Post;
    $allPosts = $post->getAllPostsLimit(); 
}

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
    
        <div class="posts block2_index">
            <div class="index_add">
                <?php if($sessionId != 0) : ?>
                <div class="index_input_box">
                        <a class="post_userinfo" href="user.php?id=<?php echo $user['id']?>" >
                            <img class="profilepicture_small" src="./images/profilepictures/<?php echo $user['profilepicture'] ?>" alt="">
                        </a>
                    <form class="index_post_form" action="uploadpost.php" method="get">
                        <input class="index_post_input " type="text" name="vraag" placeholder="Stel een vraag...">
                        <input type="hidden" name="category" value="Vraag"/>
                    </form>
                    
                </div>
                
                
                <div class="make_post">
                    <a class="index_post_button" href="uploadpost.php?category=Vraag"><img class="question-icon" src="./images/components/Group 45.svg" alt="">Vraag</a>
                    <a class="index_post_button" href="uploadpost.php?category=Oplossing"><img class="question-icon" src="./images/components/Group 46.svg" alt="">Oplossing</a>
                    <a class="index_post_button" href="uploadpost.php?category=Bericht"><img class="question-icon" src="./images/components/Group 47.svg" alt="">Bericht</a>
                </div>
                <?php endif; ?>

                <?php if($sessionId == 0) : ?>
                    <div class="index_input_box">
                        <a href="login.php"><span class="span_login">Log in</span> bij Bridge the Gap om een vraag te posten!</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php foreach ($allPosts as $p) : ?>
                <?php $allComments = Comment::getAll($p['id']); ?>
                <?php $allLikes = Like::getAll($p['id']); ?>
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
                
            <?php endforeach; ?>

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

        <div class="block3">
            <div class="block3_right">
                

                <form class="category" action="" method="get">
                    <ul class="category_items">
                        <li class="category_title">Categorieën</li>
                        <li><input class="category_btn" type="submit" name="category" value="Alles"></li>
                        <li><input class="category_btn" type="submit" name="category" value="Algemeen"></li>
                        <li><input class="category_btn" type="submit" name="category" value="Technologie"></li>
                        <li><input class="category_btn" type="submit" name="category" value="Huishouden"></li>
                        <li><input class="category_btn" type="submit" name="category" value="Koken"></li>
                    </ul>      
                </form>
            </div>
            
        </div>

    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="ajax/index.js"></script>
    
</body>
</html>