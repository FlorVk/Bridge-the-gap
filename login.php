<?php
    require_once("bootstrap.php");

    if(!empty($_POST)) {
        try {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);

            if($user->canLogin($email, $password)){
                $id = User::getIdByEmail($user->getEmail());
                $user->setUserId($id);
                $user->startSession();
                header('location: index.php'); 
            }
        } catch (Throwable $error){
            $error = $error->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="main_login">
        <div class="block1">
            <div class="img_box">
                <img class="image_login" src="./images/components/login.png" alt="">
            </div>
            
        </div>

        <div class="block2_login">
            <form class="form_login" action="" method="post">

                <h1 class="title">Login</h1>
                <p>Sluit je aan bij duizenden andere gebruikers om je verhalen en vaardigheden te delen  </p>

                <div>
                    <input class="inputField login_field" type="submit" name="loginGoogle" value="Login met Google">
                </div>

                <div class="separator">
                    <div class="line"></div>
                        <h2 class="break">OF</h2>
                    <div class="line"></div>
                </div>

                <div class="login_input">
                    <label>Email adres</label><br>
                    <input class="inputField login_field" type="email" name="email" class="inputfield"><br>

                    <label>Wachtwoord</label><br>
                    <input class="inputField login_field" type="password" name="password" class="inputfield"><br> 
                </div>
                

                <?php if (isset($error)) {
                    echo "<div class='error' id='error'>" . $error . "</div>";
                } ?>

                <button class="button" type="submit">Log in</button>
                <div class="link_register">
                <div>
                            <p>Heb je nog geen account?</p>
                            <p class="span_bottom">Wachtwoord vergeten?</p>
                    </div>

                    <div class="link_box">
                        <a id="noAccountLink" href="register.php">
                            <p class="span_login">Registreer je hier</p>
                        </a>

                        <a href="register.php">
                           <p class="span_login span_bottom">Klik hier</p> 
                        </a>
                        
                    </div>
 
                </div>
                
            </form>
        </div>
    </div>
    
</body>
</html>