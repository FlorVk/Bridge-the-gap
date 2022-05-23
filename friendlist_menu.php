<?php 
    $sessionId = $_SESSION['id'];
    $Allfriends = Relation::getFriends($sessionId);
    
    $friend = new Relation;


?><nav>
    <div >

    <div class="friend_nav">
        <form class="friend_search" action="" method="get">
            <input class="search_orange" type="text" name="search" placeholder="Zoeken">
        </form>

        <h1 class="title friends_title">Mijn vrienden</h1>
        <?php foreach ($Allfriends as $f) : ?>
            <div class="friends_list">
                <a href="user.php?id=<?php echo $friend->getUserByFriendId($f['to_id'])['to_id'] ?>" class="friends_item">
                    <div class="friends_profile">
                        <img class="profilepicture_small" src="./images/profilepictures/<?php echo $friend->getUserByFriendId($f['to_id'])['profilepicture'] ?>" alt="">
                        <h1 class="user_name username_title"><?php echo $friend->getUserByFriendId($f['to_id'])['firstname'] ?> <?php echo $friend->getUserByFriendId($f['to_id'])['lastname'] ?></h1>
                    </div>
                    <p class="icon">></p>
                </a>
            </div>
            <?php endforeach; ?>
    </div>
    

</nav>