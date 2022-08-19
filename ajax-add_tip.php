<?php
include_once("bootstrap.php");

if (isset($_POST['post'])) {
        session_start();
        $sessionId = $_SESSION['id'];
        
        $userId = $sessionId;
        $postId = $_POST["post"];

        if ((Tip::checkTipped($userId, $postId) == 1 ))
        {
            //echo "Jullie zijn al vrienden!";
        }
        else
        {
            $tip = new Tip();
            $tip->setPostId($postId);
            $tip->setUserId($userId);

            $tip->tipPost($userId, $postId);
    
        }     
    
}
else{
    //echo "something went wrong";
}
   
  
?>  