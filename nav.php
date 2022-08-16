<nav>

    <div class="nav_top">

        <a href="index.php"><img class="logo_small" src="./images/components/logo.png" alt="logo Bridge The Gap"></a>

        <form class="nav_search" action="index.php" method="get">
            <input class="search_nav" type="text" name="search" placeholder="Zoeken">

        </form>

        <?php
            if (isset($_SESSION['id'])) {
                $sessionId = $_SESSION['id'];
                $user = User::getUserFromId($sessionId);

                echo
                    "<div class='dropdown'>
                        <div class='user_details_nav dropbtn'>
                            <a class='post_userinfo' href='user.php?id=".$user['id']."'>
                            <img class='profilepicture_small user_picture' src='./images/profilepictures/".$user['profilepicture']."' alt=''>
                            <p class='user_name username_title'>".$user['firstname'] . ' ' .$user['lastname'] ."</p>
                            </a>
                        </div>
                        <div class='dropdown_menu'>
                            <a class='dropdown_item' href='user.php?id=".$user['id']."'>Mijn profiel</a>
                            <a class='dropdown_item' href='settings.php'>Instellingen</a>
                            <a class='dropdown_item' href='logout.php'>Log uit</a>
                        </div>
                    </div>";

            } else {
                echo "<div class='no_session'><a class='nav_btn' href='login.php'>Log in</a> ";
                echo "<a class='nav_btn' href='register.php'>Registreren</a></div>";
            }
        ?>

    </div>

    

    

</nav>