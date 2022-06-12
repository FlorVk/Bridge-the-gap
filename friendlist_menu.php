<?php 
    $sessionId = $_SESSION['id'];
    $Allfriends = Relation::getFriends($sessionId);
    
    $friend = new Relation;

    if (isset($_POST['search'])) {
        $user = new User;
        $allUsers = $user->getAllUsersSearch($_POST['search']);
    } else {
        
    }


?><nav>
    <div >

    <div class="friend_nav">

        <form class="friend_search" action="" method="post">
            <input class="search_orange" type="text" name="search" placeholder="Zoeken">
        </form>

        <?php if (empty($_GET['search'])) : ?>
            <h1 class="title friends_title">Mijn vrienden</h1>
            <div class="user_list">
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
                <?php if(empty($Allfriends)): ?>
                    <div>
                        <h1 class="title_medium">Helemaal leeg...</h1>
                    </div>
                <?php endif; ?>
                
            </div>
        <?php endif; ?>

        <?php if (isset($_POST['search'])) : ?>
            <h1 class="title friends_title">Zoekresultaten</h1>
            <div class="user_list">
                <?php foreach ($allUsers as $u) : ?>
                    <div class="friends_list">
                        <a href="user.php?id=<?php echo $u['id'] ?>" class="friends_item">
                            <div class="friends_profile">
                                <img class="profilepicture_small" src="./images/profilepictures/<?php echo $u['profilepicture'] ?>" alt="">
                                <h1 class="user_name username_title"><?php echo $u['firstname'] ?> <?php echo $u['lastname'] ?></h1>
                            </div>
                            <p class="icon">></p>
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if(empty($allUsers)): ?>
                    <div>
                        <h1 class="title_medium">Sorry! Geen gebruikers gevonden</h1>
                    </div>
                <?php endif; ?>
            </div>
            
            
        <?php endif; ?>

        
    </div>
    

</nav>