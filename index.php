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

$sessionId = $_SESSION['id'];




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
                <p class="index_post_button">Wat will je vragen?</p>
                <div class="make_post">
                    <a class="make_post_border" href="uploadpost.php?category=Vraag"><img class="question-icon" src="./images/components/Group 45.svg" alt="">Vraag</a>
                    <a class="make_post_border" href="uploadpost.php?category=Oplossing"><img class="question-icon" src="./images/components/Group 46.svg" alt="">Oplossing</a>
                    <a href="uploadpost.php?category=Bericht"><img class="question-icon" src="./images/components/Group 47.svg" alt="">Bericht</a>
                </div>
            </div>
            <?php foreach ($allPosts as $p) : ?>
                <?php $allComments = Comment::getAll($p['id']); ?>
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
                                        <a class="btn_hollow" href="updatepost.php?id=<?php echo $p['id']?>">Update</a>
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
                        <li><input class="category_btn category2" type="submit" name="category2" value="Vraag"><input class="category_btn category2" type="submit" name="category2" value="Antwoord"><input class="category_btn category2" type="submit" name="category2" value="Bericht"></li>
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

    
</body>
</html>