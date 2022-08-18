<?php

include_once("bootstrap.php");

session_start();

$postId = $_GET['id'];

$postData = Post::getPost($postId);

$sessionId = 0;

if(isset($_SESSION['id'])){
    $sessionId = $_SESSION['id'];
    $user = User::getUserFromId($sessionId);
}

$id = $postData['user_id'];



$posterUserData = Post::getUserByPostId($postId);
$firstNamePoster = $posterUserData['firstname'];
$lastNamePoster = $posterUserData['lastname'];
$fullnamePoster = $firstNamePoster . " " . $lastNamePoster;

$comment = new Comment;
$allComments = Comment::getAll($postId); 
$allLikes = Like::getAll($postId);



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css"> 
    <script src="https://kit.fontawesome.com/b01dc45dc5.js" crossorigin="anonymous"></script>
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

        <div class="postContainer block2">
            <div class="detail_box">
                <div class="detail_container">
                   <div class="posterContainer">
                       <div class="poster_head">
                            <a href="user.php?id=<?php echo $postData['user_id'] ?>" class="post_userinfo">
                                <img class="profilepicture_medium" src="./images/profilepictures/<?php echo $posterUserData['profilepicture'] ?>" alt="">
                                <div class="post_username"><h1 class="username_title"><?php echo $fullnamePoster ?></h1>
                            </a>
                                    <p class="updated_when"><?php echo "Geüpdate ".$postData['time_posted']; ?></p>
                                </div>
                       </div>

                       <div>
                            <?php if($sessionId == $id) : ?>
                                <div class="user_self">
                                    <a class="btn_hollow" href="updatepost.php?id=<?php echo $postData['id']?>">Update post</a>
                                </div> 
                            <?php endif; ?>
                       </div>
                        

                        
                    </div> 

                    <div class="postImgContainer">
                        <p class="post_title"><?php echo $postData['title']; ?></p>
                        <p class="post_description"><?php echo $postData['description']; ?></p>

                        <?php if(isset($postData['img_path'])) : ?>
                            <div class="post_content_image">
                                <img class="postpicture_large" src="images/postpictures/<?php echo $postData['img_path']; ?>" alt="Post picture">
                            </div> 
                        <?php endif; ?>
                    </div>

                    <div>

                    <div class="likesContainer">
                            <div class="post__foot__likes">
                                <?php if(Like::isPostLiked($user['id'], $postData['id'])): ?>
                                    <a href="#" id="btnAddLike" data-postid="<?php echo $postData['id']; ?>" data-isliked="false" data-username="<?php echo $userData['firstname']; ?>" data-userid="<?php echo $userData['id']; ?>"><img class="nav-icon" src="images/components/home.svg" alt="Number of likes" /></a>
                                <?php else: ?>
                                    <a href="#" id="btnAddLike" data-postid="<?php echo $postData['id']; ?>" data-isliked="true" data-username="<?php echo $userData['firstname']; ?>" data-userid="<?php echo $userData['id']; ?>"><img class="nav-icon" src="images/components/home.svg" alt="Number of likes" /></a>
                                <?php endif; ?>
                                <span class="likeCount"><?php echo count($allLikes); ?></span>
                            </div>
                            <ul class="hoverBubble">
                                <?php foreach($allLikes as $like): ?>
                                    <?php if($like['user_id'] == $sessionId): ?>
                                        <li data-likeuserid="current-user"><?php echo htmlspecialchars($like['firstname']) ?></li>
                                    <?php else: ?>
                                        <li data-likeuserid="<?php echo $like['user_id']; ?>"><?php echo htmlspecialchars($like['firstname']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                    <?php if($sessionId != 0) : ?>
                        <div class="post_comments">
                            <div class="post_comments_form">
                                <input class="comment_input" type="text" id="commentText" placeholder="Antwoord op vraag">
                                <a href="#" class="post_comment_button" id="btnAddComment" data-postid="<?php echo $postData['id']; ?>">Plaats</a>
                            </div>
                        </div>
                    <?php endif; ?>
                        

                        <div class="comments">

                            <ul class="commentsList">
                                <?php foreach ($allComments as $c) : ?>
                                    <li>
                                        <div class="comment">
                                            <a href="user.php?id=<?php echo $postData['user_id'] ?>"><p class="username_title comment_title"><?php echo  $c['firstname'] ?> <?php echo  $c['lastname'] ?></p></a>
                                            <p class="comment_text"><?php echo htmlspecialchars($c['comment']) ?></p>
                                        </div>
                                        <p class="updated_when"><?php echo $c['date'] ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                        </div>
                    </div>
                </div>

            </div>
            </div>
            

        <div class="block3">
            <div class="block3_right">
                
            </div>
        </div>
    </div>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        document.querySelector("#btnAddComment").addEventListener("click", function() {
            let postId = this.dataset.postid;
            let text = document.querySelector("#commentText").value;
        
            event.preventDefault();
            console.log(postId);
            console.log(text);

            const formData = new FormData();

            formData.append('text', text);
            formData.append('postId', postId);

            fetch('ajax-add_comment.php', {
            method: 'POST',
            body: formData
            })
            .then(response => response.json())
            .then(result => {
                let newComment = document.createElement('ul');
                newComment.innerHTML = result.data.user + ": " + result.data.comment;
                document.querySelector(".commentsList").appendChild(newComment);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });

            //let commentCount = parseInt(e.querySelector(".commentCount").innerHTML);
            //commentCount++;
            //e.querySelector('.commentCount').innerHTML = commentCount;
            }); 
  
    </script>
    <script>
        document.querySelector("#btnAddComment").addEventListener("click", function() {
           
            }); 
    </script>
</body>
</html>