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
            //echo "Jullie zijn al vrienden!";
        }
        elseif (Relation::checkFriends($fromId, $toId) == 2 || Relation::checkFriendsTo($toId, $fromId) == 2)
        {
            $friend = new Relation();
            $friend->setFromId($fromId);
            $friend->setToId($toId);

            if (Relation::checkPendingFrom($fromId, $toId) == 1) {
                //echo "pending from you";
            }
            elseif (Relation::checkPendingTo($toId, $fromId) == 1){
                //echo "pending from other person";
                $friend->addFriend($fromId, $toId);
                $friend->acceptFriend($toId, $fromId);
            }
    
        
        $user = User::getUserFromId($toId);

        //echo "Je bent bevriend met<b>".json_encode($user["firstname"])."</b>";
        }
    
}
else{
    //echo "something went wrong";
}
   
  
?>  