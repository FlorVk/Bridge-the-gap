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
            <h1 class="title">Work in progress! Kom snel terug!</h1>
            </div>
            

            

            

            

        </div>

        <div class="block3">
            <div class="block3_friendlist">
                <?php include('friendlist_menu.php'); ?>  
            </div>
        </div>

    </div>

    
</body>
</html>