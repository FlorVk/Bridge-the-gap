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
            $request = new Relation();

        $request->cancelRequest($fromId, $toId);
    
        
        $user = User::getUserFromId($toId);

        //echo "Je hebt je vriendschapsverzoek naar  <b>".json_encode($user["firstname"])."</b> geanuleerd";

        //header('location: user.php?id='.$toId);
            
        }
        elseif (Relation::checkPendingFrom($fromId, $toId) == 2 || Relation::checkPendingTo($toId, $fromId) == 2)
        {
       
            //echo "Al een verzoek gestuurd!";
        
        }
    
}
else{
    //echo "something went wrong";
}
   
  
?>  