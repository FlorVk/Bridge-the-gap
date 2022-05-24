<?php
require_once('bootstrap.php');

if (!empty($_POST)) {
    session_start();
    $sessionId = $_SESSION['id'];
    $userData = User::getUserFromId($sessionId);
    $userId = $sessionId;
    $postId = $_POST['postId'];
    $comment = $_POST['text'];

    //new comment
    $c = new Comment();
    $c->setComment($_POST['text']);
    $c->setPostId($_POST['postId']);
    $c->setUserId($sessionId);

    //save comment
    $c->addComment();

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($c->getComment()),
        "data" => [
            "comment" => htmlspecialchars($c->getComment()),
            "user" => htmlspecialchars($userData['firstname']),
        ],
        'message' => 'Comment saved'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>