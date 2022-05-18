<?php
require_once("bootstrap.php");
session_start();

$post = new Post();
$id = $_GET['id'];
$postData = Post::getPost($id);
$sessionId = $_SESSION['id'];

$userId = $postData['user_id'];
$posterId = User::getUserFromId($sessionId);


if ($sessionId = $userId ){
    Post::deletePostByPostId($id);
    header("Location: index.php");
}
else {
    echo "not your post";
}

?>