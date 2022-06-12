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

$title = new Title;
$allTitles = $title->getAllTitles();




if (!empty($_POST)) {
    try {

        $title = new Title();
        $user->setTitle($_POST['title']);
        $user->setUserId($sessionId);

        $user->updateTitle();

        header('location: user.php?id='.$userData['id']);


    } catch (Throwable $error) {
        $error = $error->getMessage();
    }
}






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
    
        <div class="posts block2_index block2_title">
           <h1 class="title title_badge">Kies een titel die bij jou past!</h1>
           <h2>Deze titel kan je elk moment aanpassen en zal op je profiel terug te vinden zijn!</h2>

           <form action="" method="post" class="form_title">
            
                <input class="button title_button" type="submit" name="submit" value="Kies deze titel">
                
                <?php foreach ($allTitles as $t) : ?>

                    <div class="badges_container">

                            <input type="radio" id="<?php echo $t['id'] ?>" class="radio_title" name="title" value=<?php echo $t['id'] ?>>

                            <label class="label_title" for="<?php echo $t['id'] ?>">
                                <img class="badge_small" src="./images/badges/junior/<?php echo $t['badge'] ?>" alt="">
                                <h1 class="title_name"><?php echo $t['title_name'] ?></h1>
                            </label>

                    </div>


                <?php endforeach; ?>

           </form>

           <a target="_blank" href="https://icons8.com/icon/set/animals/bubbles"></a> icons by <a target="_blank" href="https://icons8.com">Icons8</a>
           

            

        </div>

        <div class="block3">
            <div class="block3_right">
                
            </div>
            
        </div>

    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

    
</body>
</html>


