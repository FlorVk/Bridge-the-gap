<nav>
    <div class="nav_left">
        <?php
            if (isset($_SESSION['id'])) {
                $sessionId = $_SESSION['id'];
                $user = User::getUserFromId($sessionId);

                echo
                    "<div class='user_details'>
                        <a class='post_userinfo' href='user.php?id=".$user['id']."'>
                        <img class='profilepicture_small user_picture' src='./images/profilepictures/".$user['profilepicture']."' alt=''>
                        <p class='user_name username_title'>".$user['firstname'] . ' ' .$user['lastname'] ."</p>
                        </a>
                    </div>";

            } else {
                echo "<div class='no_session'><a class='nav_btn' href='login.php'>Log in</a> ";
                echo "<a class='nav_btn' href='register.php'>Registreren</a></div>";
            }
        ?>

        <ul class="menu_items">
            <li><a href="index.php"><img class="nav-icon" src="./images/components/home.svg" alt=""><a class="menu_item" href="index.php">Home</a></a></li>
            <li><a href="call.php"><img class="nav-icon" src="./images/components/phone-call.svg" alt=""><a class="menu_item" href="call.php">Bellen</a></a></li>
            <li><a href="chat.php"><img class="nav-icon" src="./images/components/comment.svg" alt=""><a class="menu_item" href="chat.php">Berichten</a></a></li>
            <li><a href="settings.php"><img class="nav-icon" src="./images/components/settings.svg" alt=""><a class="menu_item" href="settings.php">Instellingen</a></a></li>
        </ul>
    </div>
    

</nav>