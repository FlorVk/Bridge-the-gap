<?php

include_once("bootstrap.php");

session_start();

$sessionId = $_SESSION['id'];
$userId = $_GET['id'];

$userData = User::getUserFromId($userId);

$firstName = $userData['firstname'];
$lastName = $userData['lastname'];
$fullname = $firstName . " " . $lastName;

$id = $_GET['id'];
$allPosts = Post::getPostsByUserId($id);

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

        <div class="user_profile block2_index">
            <div class="user_profile">
                <div class="user_content ">
                <div id='showcase-success'></div>
                    <div class="poster_head">
                        <img class="profilepicture_medium" src="./images/profilepictures/<?php echo $userData['profilepicture'] ?>" alt="">
                        <h1 class="username_title username_user"><?php echo $fullname ?>
                        <p class="user_senior"><?php echo $userData['senior']; ?></p> </h1>
                    </div>

                    <div class="user__information">
                        <p class="user__bio"><?php echo $userData['bio']; ?></p>
                    </div>

                    <?php if($sessionId == $id) : ?>
                        <div class="user__self user_buttons">
                            <a class="btn_hollow" href="settings.php"> Settings</a>
                            <a class="button" href="logout.php">Logout</a>
                        </div> 
                    <?php endif; ?>

                    <?php
                        if ($sessionId != $id){
                            // Nog geen pending en vriendschapsverzoek aanwezig:
                            if (Relation::checkPendingFrom($sessionId, $id) == 2 && Relation::checkPendingTo($id, $sessionId) == 2 && Relation::checkFriends($sessionId, $id) == 2){
                                echo '<input type="button" data-id="'.$id.'" class="add button" id="pendButton" name="friend"  value="Stuur vriendschapsverzoek!"/ >';
                                }
                            // WEl een pending en geen vriendschapsverzoek aanwezig:
                            elseif (Relation::checkFriends($sessionId, $id) == 2 && (Relation::checkPendingFrom($sessionId, $id) == 1 || Relation::checkPendingTo($id, $sessionId) == 1) ){
                                if (Relation::checkPendingFrom($sessionId, $id) == 1){
                                    echo '<input type="button" data-id="'.$id.'" class="add btn_hollow" id="unpendButton" name="friend"  value="Annuleer vriendschapsverzoek"/ >';
                                    }
                                else {
                                    echo '<input type="button" data-id="'.$id.'" class="add button" id="friendButton" name="friend"  value="Accepteer vriendschapsverzoek"/ >';
                                    }
                            }
                            // WEl een vriend:
                            elseif ((Relation::checkFriends($sessionId, $id) == 1)){
                                echo '<input type="button" data-id="'.$id.'" class="remove btn_hollow" id="unfriendButton" name="friend"  value="Verwijder als vriend" />';            
                            }
                        }
                    ?>
                </div>
                
                <div class="posts">
                    <?php foreach ($allPosts as $p) : ?>
                        <div class="post user_post">
                                <div class="post_content">
                                    <a href="detailpost.php?id=<?php echo $p['id'] ?>">
                                    <div class="post_content_box">
                                                <div class="posterContainer">
                                                <p class="updated_when"><?php echo "Geüpdate ".$p['time_posted']; ?></p>
                                                <div>
                                                        <?php if($sessionId == $id) : ?>
                                                            <div class="user_self">
                                                                <a class="btn_hollow" href="updatepost.php?id=<?php echo $p['id']?>">Update</a>
                                                            </div> 
                                                        <?php endif; ?>
                                                </div> 
                                                </div>
                                                <a href="detailpost.php?id=<?php echo $p['id'] ?>">
                                                    <p class="post_title"><?php echo $p['title']; ?></p>
                                                    <p class="post_description"><?php echo $p['description']; ?></p>
                                                </a>
                                                
                                            </div>
                                    </a>
                                            

                                            <?php if(isset($p['img_path'])) : ?>
                                                <a href="detailpost.php?id=<?php echo $p['id'] ?>">
                                                <div class="post_content_image">
                                                    <img class="postpicture_medium" src="images/postpictures/<?php echo $p['img_path']; ?>" alt="Post picture">
                                                </div>
                                            </a>
                                             
                                            <?php endif; ?>
                                    </div>    
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            

        </div>
        <div class="block3">
            <div class="block3_friendlist">
                <?php if($sessionId == $id) : ?>
                    <?php include('friendlist_menu.php'); ?>
                <?php endif; ?>
                    
            </div>
        </div>
        

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    
        $(document).on("click","#friendButton",function(){
            console.log("press");
        $("#unfriendButton").show();
        $("#friendButton").hide();
        $.ajax({  
            url:"ajax-add_friend.php",  
            method:"POST",
            data:{
                to: $(this).attr("data-id"),
                from: <?php echo htmlspecialchars($sessionId) ?> 
            
            },  
            success:function(data){ 
                $('#showcase-success').html(data); 
                $('#showcase-success').addClass("show");
                location.reload();
            } 
        }); 
    }); 
    $(document).on("click","#unfriendButton",function(){
        console.log("press");
        $("#friendButton").show();
        $("#unfriendButton").hide();
        $.ajax({  
            url:"ajax-remove_friend.php",
            method:"POST",  
            data:{
                to: $(this).attr("data-id"),
                from: <?php echo htmlspecialchars($sessionId) ?> 
            },  
            success:function(data){ 
                $('#showcase-success').html(data); 
                $('#showcase-success').addClass("show");
                location.reload();
            } 
        }); 
    }); 
    $(document).on("click","#pendButton",function(){
        console.log("press");
        $("#pendButton").show();
        $("#unpendingButton").hide();
        $.ajax({  
            url:"ajax-request_friend.php",
            method:"POST",  
            data:{
                to: $(this).attr("data-id"),
                from: <?php echo htmlspecialchars($sessionId) ?> 
            },  
            success:function(data){ 
                $('#showcase-success').html(data); 
                $('#showcase-success').addClass("show");
                location.reload();
            } 
        }); 
    });

    $(document).on("click","#unpendButton",function(){
        console.log("press");
        $("#unpendButton").show();
        $("#pendButton").hide();
        $.ajax({  
            url:"ajax-remove_request.php", 
            method:"POST",  
            data:{
                to: $(this).attr("data-id"),
                from: <?php echo htmlspecialchars($sessionId) ?> 
            },  
            success:function(data){ 
                $('#showcase-success').html(data); 
                $('#showcase-success').addClass("show");
                location.reload();
            } 
        }); 
    });

    </script>

    

    


</body>
</html>