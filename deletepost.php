<?php
require_once("bootstrap.php");

session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login.php');
    } else{
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    }

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