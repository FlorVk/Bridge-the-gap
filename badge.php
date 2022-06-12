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


    if (!empty($_POST['update'])) {
        try {

            $title = new Title();
            $title->setTitleId($_POST['title']);

           $titleId = $title->setTitleId($_POST['title']);
           echo $titleId;
            $title->setUserId($sessionId);
    
            $title->updateTitle();;

            header('location: badge.php');

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
    <title>Update gegevens</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/lhb7fhc.css">
</head>

<body>

<header>
        <?php include('nav.php');?>
</header>

<?php if (!empty($error)) {
        echo $error;
    } ?>

    <div class="main">

        <div class="block1">
            <div class="block1_left">
                <?php include('nav_left.php'); ?>
            </div>
        </div>

        <div class="block2_update">
            <div class="usersettings_box">
                
            <h1 class="title">Kies een titel</h1>
                <form action="" method="post" class="profile_info">
                            

                            <div class="radio_buttons">
                                <div>
                                    <input type="radio" name="title" value=1>
                                    <label for="">Ik ben een cool cat <span class="span_login">( leeftijden van 14 tot 30 jaar)</span></label>
                                </div>
                                <div>
                                    <input type="radio" name="title" value=2>
                                    <label for="">Ik ben een trotse zwaan <span class="span_login">( leeftijden over de 30 jaar)</span></label>
                                </div>
                            </div>
                            
                            <input class="button" type="submit" name="update" value="Update je gegevens">
                </form> 
            </div>
        </div>

        <div class="block3_update update_border">
            <div class="block3_right updateRight">
            
            </div>
        </div>
        
    </div>

    


</body>

</html>