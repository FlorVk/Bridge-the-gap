<?php
include_once("bootstrap.php");

if (isset($_POST['to'])) {
        //echo "help";
        session_start();
        $sessionId = $_SESSION['id'];
        
        $fromId = $sessionId;
        $toId = $_POST["to"];

        if ((Relation::checkPendingFrom($fromId, $toId) == 1 || Relation::checkPendingTo($toId, $fromId) == 1))
        {
            //echo "Al een verzoek gestuurd!";
        }
        elseif (Relation::checkPendingFrom($fromId, $toId) == 2 || Relation::checkPendingTo($toId, $fromId) == 2)
        {
       
        
        $request = new Relation();
        $request->setFromId($fromId);
        $request->setToId($toId);

        $request->addFriendRequest();
    
        
        $user = User::getUserFromId($toId);

        //echo "Je hebt een vriendschapsverzoek verstuurd naar <b>".json_encode($user["firstname"])."</b>";
        }
    
}
else{
    //echo "something went wrong";
}
   
  
?>  