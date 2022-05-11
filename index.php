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
    <link rel="stylesheet" href="styles/style.css">  
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>

    <div class="posts">
        <?php foreach ($allPosts as $p) : ?>

            <div class="post">

                    <a href="userdata.php?id=<?php echo $p['user_id'] ?>" class="post_userinfo">
                        <img class="profilepicture_small" src="./images/profilepictures/<?php echo $post->getUserByPostId($p['id'])['profilepicture'] ?>" alt="">
                        <p class="post_username"><?php echo $post->getUserByPostId($p['id'])['firstname'] ?></p>
                    </a>
                    <div class="post_content">
                        <a class="post_detail" href="detailPost.php?id=<?php echo $p['id'] ?>">
                            <p><?php echo "Geupdate ".$p['time_posted']; ?></p>
                            <p><?php echo $p['title']; ?></p>
                            <p><?php echo $p['description']; ?></p>
                        </a>
                        
                    </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!isset($_GET['search'])) : ?>
        <div class="pages">
            <?php for ($pages = 1; $pages <= $total_pages; $pages++) : ?>
                <a href='<?php echo "?page=$pages"; ?>' class="links"><?php echo $pages; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</body>
</html>