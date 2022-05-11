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
</head>
<body>

    <form class="form" action="" method="post">

      <h1>Maak een account aan</h1>

      <label>Voornaam</label>
      <input type="text" name="firstname" class="inputfield"><br>

      <label>Achternaam</label>
      <input type="text" name="lastname" class="inputfield"><br>

      <label>Email adres</label>
      <input type="email" name="email" class="inputfield"><br>

      <label>Wachtwoord</label>
      <input type="password" name="password" class="inputfield"><br>

      <label>Herhaal wachtwoord</label>
      <input type="password" name="comfirmPassword" class="inputfield"><br>

      <input type="checkbox"></input>
      <span>Ik ben geen robot</span>

      <?php if (isset($error)) {
        echo "<div id='error'>" . $error . "</div>";
      } ?>

      <button type="submit">Account aanmaken</button>
      <a href="login.php" id="noAccountLink">Heb je al een account? <span>Log je dan hier in</span></a><br>
    </form>

</body>
</html>