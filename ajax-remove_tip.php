<?php
include_once("bootstrap.php");

if (isset($_POST['post'])) {
        session_start();
        $sessionId = $_SESSION['id'];
        
        $userId = $sessionId;
        $postId = $_POST["post"];

        if ((Tip::checkTipped($userId, $postId) == 2 ))
        {
            //echo "Nog niet leuk gevonden";
        }
        else
        {
            $tip = new Tip();
            $tip->setPostId($postId);
            $tip->setUserId($userId);

            $tip->untipPost($userId, $postId);
        }     
    
}
else{
    //echo "something went wrong";
}
   
  
?> 