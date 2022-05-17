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
    
        <div class="posts block2_index">
            <?php foreach ($allPosts as $p) : ?>
                <div class="post">
                        <a href="user.php?id=<?php echo $p['user_id'] ?>" class="post_userinfo">
                            <img class="profilepicture_small" src="./images/profilepictures/<?php echo $post->getUserByPostId($p['id'])['profilepicture'] ?>" alt="">
                            <p class="post_username"><?php echo $post->getUserByPostId($p['id'])['firstname']?></p>
                        </a>

                        <div class="post_content">
                            <a class="post_detail" href="detailPost.php?id=<?php echo $p['id'] ?>">

                            <div class="post_content_box">
                                <p><?php echo "Geupdate ".$p['time_posted']; ?></p>
                                <p class="post_title"><?php echo $p['title']; ?></p>
                                <p class="post_description"><?php echo $p['description']; ?></p>
                            </div>

                            <div class="post_content_image">
                                <img class="postpicture_medium" src="./images/postpictures/<?php echo $p['img_path']; ?>" alt="">
                            </div>
                                
                            </a>
                            
                        </div>
                </div>
            <?php endforeach; ?>

            <?php if (!isset($_GET['search'])) : ?>
            <div class="pages">
                <?php for ($pages = 1; $pages <= $total_pages; $pages++) : ?>
                    <a href='<?php echo "?page=$pages"; ?>' class="links"><?php echo $pages; ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        </div>

        <div class="block3">
            <div class="block3_right">
                <ul class="category_items">
                    <li class="category_title">Categorieën</li>
                    <li>cat 1</li>
                    <li>cat 2</li>
                    <li>cat 3</li>
                    <li>cat 4</li>
                    <li>cat 5</li>
                </ul>
            </div>
            
        </div>

    </div>

    
</body>
</html>