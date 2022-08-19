<?php
include_once("bootstrap.php");

if (isset($_POST['post'])) {
        session_start();
        $sessionId = $_SESSION['id'];
        
        $userId = $sessionId;
        $postId = $_POST["post"];

        if ((Like::checkLiked($userId, $postId) == 2 ))
        {
            //echo "Nog niet leuk gevonden";
        }
        else
        {
            $like = new Like();
            $like->setPostId($postId);
            $like->setUserId($userId);

            $like->unlikePost($userId, $postId);
        }     
    
}
else{
    //echo "something went wrong";
}
   
  
?> 