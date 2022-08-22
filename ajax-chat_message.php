<?php
require_once('bootstrap.php');

if (!empty($_POST)) {
    session_start();
    $sessionId = $_SESSION['id'];
    $userData = User::getUserFromId($sessionId);
    $userId = $sessionId;

    $outgoing = $_POST['outgoing'];
    $incoming = $_POST['incoming'];
    $message = $_POST['text'];


    $chat = new Chat();
    

    $chat->AddMessage($outgoing, $incoming, $message);

}

?>