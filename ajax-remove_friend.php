<?php
include_once("bootstrap.php");

if (isset($_POST['to'])) {
        //echo "help";
        session_start();
        $sessionId = $_SESSION['id'];
        
        $fromId = $sessionId;
        $toId = $_POST["to"];

        if ((Relation::checkFriends($fromId, $toId) == 1 || Relation::checkFriendsTo($toId, $fromId) == 1))
        {
            $friend = new Relation();
            
            $friend->unfriend($fromId, $toId);
            $friend->unfriend($toId, $fromId);

            $user = User::getUserFromId($toId);

            //echo "Je bent niet meer bevriend met  <b>".json_encode($user["firstname"])."</b>";
            
        }
        elseif (Relation::checkFriends($fromId, $toId) == 2 || Relation::checkFriendsTo($toId, $fromId) == 2)
        {
            //echo "Jullie zijn al vrienden!";
        }
    
}
else{
    //echo "something went wrong";
}
   
  
?>  