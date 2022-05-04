<nav>

    <div class="nav_left">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="">Bellen</a></li>
            <li><a href="">Berichten</a></li>
            <li><a href="">Instellingen</a></li>
        </ul>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $user = User::getUserFromId($sessionId);

        echo
            "<div>
                <img class='profilepicture_small' src='./images/profilepictures/standard.png' alt=''>
                <p>".$user['firstname'] . ' ' .$user['lastname'] ."</p>
            </div>";

        //temp in nav ->
        echo "<a class='nav_btn' href='logout.php'>Log out</a>";
    } else {
        echo "<div class='nav_right'><a class='nav_btn' href='login.php'>Log in</a> ";
        echo "<a class='nav_btn' href='register.php'>Registreren</a></div>";
    }

    ?>

</nav>