<?php 
    require_once("bootstrap.php");

    if(!empty($_POST)){
        try{
            if(!empty($_POST['password']) && $_POST['password'] === $_POST['comfirmPassword']){
                $user = new User();

                $user->setFirstname($_POST['firstname']);
                $user->setLastname($_POST['lastname']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setProfilePicture("standard.png");

                if(isset($_POST['senior'])) {
                    $user->setSenior($_POST['senior']); 
                }
                
                $user->register();

                $id = User::getIdByEmail($user->getEmail());
                $user->setUserId($id);
                
                $user->startSession();
                
                
            }
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
    <title>Register</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

    <div class="main_login">
        <div class="block1">
            <div class="img_box">
                <img class="image_login" src="./images/components/register.png" alt="">
            </div>
        </div>

        <div class="block2_login">
            <form class="form_login" action="" method="post">

                <h1 class="title">Maak een account aan</h1>

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
                    <div class="updateName">
                        <div class="inputFieldRegister inputFieldRegister1" >
                           <label>Voornaam</label>
                            <input type="text" name="firstname" class="inputField login_field">
                        </div>
                        <div class="inputFieldRegister">
                            <label>Achternaam</label>
                            <input type="text" name="lastname" class="inputField login_field">
                        </div>
                        
                        </div>
                    
                    <label>Email adres</label>
                    <input type="email" name="email" class="inputField login_field"><br>

                    <label>Wachtwoord</label>
                    <input type="password" name="password" class="inputField login_field"><br>

                    <label>Herhaal wachtwoord</label>
                    <input type="password" name="comfirmPassword" class="inputField login_field"><br>

                </div>
                
                <div>
                    <div>
                        <input type="radio" name="senior" value="Senior">
                        <label for="">Ik registreer me als 65-plusser</label>
                    </div>
                    <div>
                        <input type="radio" name="senior" value="Junior">
                        <label for="">Ik ben geen 65-plusser</label>
                    </div>
                </div>

                <?php if (isset($error)) {
                echo "<div id='error'>" . $error . "</div>";
                } ?>

                <button class="button" type="submit">Account aanmaken</button><br>
                    <div class="link_register">
                        <div>
                            <p>Heb je al een account?</p>
                        </div>

                    <div class="link_box">
                        <a id="noAccountLink" href="register.php">
                            <p class="span_login">Log je hier in</p>
                        </a>
                    </div>
                </div>
            </div>
    </div>

    

</body>
</html>