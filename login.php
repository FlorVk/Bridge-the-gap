<?php
    require_once("bootstrap.php");

    if(!empty($_POST)) {
        try {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new USer();
            $user->setEmail($email);
            $user->setPassword($password);

            if($user->canLogin($email, $password)){
                $id = User::getIdByEmail($user->getEmail());
                $user->setUserId($id);
                $user->startSession();  
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
</head>
<body>
    <form class="form" action="" method="post">

        <h1>Login</h1>

        <label>Email adres</label>
        <input type="email" name="email" class="inputfield"><br>

        <label>Wachtwoord</label>
        <input type="password" name="password" class="inputfield"><br>

        <?php if (isset($error)) {
        echo "<div id='error'>" . $error . "</div>";
        } ?>

        <button type="submit">Log in</button>
        <a href="register.php" id="noAccountLink">Heb je al nog geen account? <span>Registreer je hier</span></a><br>
        <a href="#" id="noAccountLink">Wachtwoord vergeten? <span>Klik hier</span></a><br>
    </form>
</body>
</html>