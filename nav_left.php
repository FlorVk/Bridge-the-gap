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
                        <p class='user_name'>".$user['firstname'] . ' ' .$user['lastname'] ."</p>
                        </a>
                    </div>";

            } else {
                echo "<div class='no_session'><a class='nav_btn' href='login.php'>Log in</a> ";
                echo "<a class='nav_btn' href='register.php'>Registreren</a></div>";
            }
        ?>

        <ul class="menu_items">
            <li><a class="menu_item" href="index.php">Home</a></li>
            <li><a class="menu_item" href="">Bellen</a></li>
            <li><a class="menu_item" href="">Berichten</a></li>
            <li><a class="menu_item" href="usersettings.php">Instellingen</a></li>
        </ul>
    </div>
    

</nav>