<?php

include_once("bootstrap.php");

session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login.php');
    } else{
        $user = new User();
        $sessionId = $_SESSION['id'];
        $userData = User::getUserFromId($sessionId);
    }

if (isset($_GET['id'])) {
    $chatterId = $_GET['id'];
    $chatUser = User::getUserFromId($chatterId);
    $allMessages = Chat::getAllMessages($chatterId, $sessionId);
//var_dump($allMessages);
}

$allUsers = User::getAllUsers();




$sessionId = $_SESSION['id'];



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title> 
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css">
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>

    <div class="main">

        <div class="block1">
            <div class="block1_left">
                <?php include('nav_left.php'); ?>
            </div>
        </div>
    
        <div class="posts block2_index">
            

            <?php if (isset($_GET['id'])): ?>
            
                <div class="wrapper">
                <section>
                <div class='user_details'>
                    <a class="post_userinfo" href="user.php?id=<?php echo $chatUser['id'] ?>">
                        <img class="profilepicture_small" src="./images/profilepictures/<?php echo $chatUser['profilepicture'] ?>" alt="">
                        <p class='user_name username_title'><?php echo $chatUser['firstname']." ".$chatUser['lastname'] ?></p>
                    </a>
                </div>
                

                <div class="chat_box">
                <?php foreach ($allMessages as $m) : ?>

                <?php if($m['incoming'] === $sessionId){
                    echo 
                    "<div class='chat_outgoing'>
                        <div class='chat_details_outgoing'>
                            <p class='chat_text'>".$m['message']."</p>
                        </div>
                    </div>";
                } elseif ($m['outgoing'] === $sessionId) {
                    echo 
                    "<div class='chat_incoming'>
                        <div class='chat_details_incoming'>
                            <p class='chat_text'>".$m['message']."</p>
                        </div>
                    </div>";
                }
                 ?>
                

                    
                    <?php endforeach; ?>
                    
                </div>
                <form action="#" class="typing-box" autocomplete="off">
                    <input type="text" id="input-field" placeholder="Typ hier">
                    <a href="#" class="post_comment_button" id="btn-chat" data-incoming="<?php echo $chatterId; ?>" data-outgoing="<?php echo $sessionId; ?>">Plaats</a>
                </form>
                </section>
            </div>

            <?php endif; ?>
            
        
            <?php if (!isset($_GET['id'])): ?>
                <div class="index_add">
                <div class="index_input_box">
                <h1 class="title friends_title">Chat met iemand...</h1>
                    
                </div>
                
                
                <div class="make_post">
                    <?php foreach ($allUsers as $u) : ?>
                        <a class="index_post_button" href="chat.php?id=<?php echo $u['id'] ?>"><img class="profilepicture_small" src="./images/profilepictures/<?php echo $u['profilepicture'] ?>" alt=""><?php echo $u['firstname']." ".$u['lastname'] ?></a>
                    <?php endforeach; ?>
                    
                </div>
            </div>

        
            <?php endif; ?>

            

            

        </div>

        <div class="block3">
            <div class="block3_friendlist">
                <?php include('friendlist_menu.php'); ?>  
            </div>
        </div>

    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="ajax/chat.js"></script>
    

</body>
</html>