<?php 
    include_once(__DIR__ . "/Db.php");

    class User
    {
        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $profilepicture;
        private $senior;
        private $userId;
        private $bio;
        private $title;
    

        public function getFirstname()
        {
            return $this->firstname;
        }

        public function setFirstname($firstname)
        {
            if (empty($firstname)) {
                throw new Exception("Een voornaam is nodig.");
            }
            $this->firstname = $firstname;

            return $this;
        }

        public function getLastname()
        {
            return $this->lastname;
        }

        public function setLastname($lastname)
        {
            if (empty($lastname)) {
                throw new Exception("Naam mag niet leeg zijn.");
            }
            $this->lastname = $lastname;
            return $this;
        }

        public function setEmail($email)
        {
            if (!empty($email)) {
                $this->email = $email;
                return $this;
            } else {
                throw new Exception("Je hebt een email nodig.");
            }
        }
        public function getEmail()
        {
            return $this->email;
        }

        public function getPassword()
        {
                return $this->password;
        }

        public function setPassword($password)
        {
                if (strlen($password) < 5) {
                        throw new Exception("Wachtwoord moet meer dan 5 tekens bevatten.");
                }
                $this->password = $password;
                return $this;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
            return $this;
        }
        
        public function getUserId() {
            return $this->userId;
        }

        public function setSenior($senior) {
            $this->senior = $senior;
            return $this;
        }
        
        public function getSenior() {
            return $this->senior;
        }

        public function setTitle($title) {
            $this->title = $title;
            return $this;
        }
        
        public function getTitle() {
            return $this->title;
        }

        public static function checkSenior($id){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT senior FROM users WHERE `id` = :id;");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch();
            if ($result === "Senior") {
                    echo "Junior";
            } else {
                    echo "Senior";
            }
        }

        public function setBio($bio) {
            $this->bio = $bio;
            return $this;
        }
        
        public function getBio() {
            return $this->bio;
        }

        public function setProfilePicture($profilepicture)
        {
            if (!empty($profilepicture)) {
                $this->profilepicture = $profilepicture;
                return $this;
            } else {
                throw new Exception("Foto mag niet leeg zijn.");
            }
        }
        public function getProfilePicture()
        {
            return $this->profilepicture;
        }

        public function register()
        {
                $options = [
                        'cost' => 12
                ];

                $password = password_hash($this->password, PASSWORD_BCRYPT, $options);
                $conn = Db::getInstance();
                $statement = $conn->prepare("INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `profilepicture`, `senior`) VALUES (:firstname, :lastname, :email, :password, :profilepicture, :senior);");
                $statement->bindValue(':firstname', $this->firstname);
                $statement->bindValue(':lastname', $this->lastname);
                $statement->bindValue(':email', $this->email);
                $statement->bindValue(':password', $password);
                $statement->bindValue(':profilepicture', $this->profilepicture);
                $statement->bindValue(':senior', $this->senior);
                return $statement->execute();
        }

        public function canLogin($email, $password)
        {
                $conn = Db::getInstance();
                $statement = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email;");
                $statement->bindValue(':email', $email);
                $statement->execute();
                $result = $statement->fetch();

                if (!$result) {
                        throw new Exception("Gebruiker bestaat niet!");
                        return false;
                }
                $hash = $result["password"];
                if (password_verify($password, $hash)) {
                        return true;
                } else {
                        throw new Exception("Verkeerd wachtwoord");
                        return false;
                }
        }

        public static function getIdByEmail($email)
        {
            $conn = Db::getInstance();
            $sql = "SELECT `id` FROM `users` WHERE `email` = '$email';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch();
            return $result['id'];
        }

        public static function getUserFromId($id)
        {
            $conn = Db::getInstance();
            $sql = "SELECT * FROM `users` WHERE `id` = '$id';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }


        public function startSession() {
            $sessionId = $this->getUserId();
    
            session_start();
            $_SESSION['id'] = $sessionId;

            header('location: index.php');
        }

        public function updateProfilePicture($profilepicture, $userId)
        {
                $conn = Db::getInstance();
                $statement = $conn->prepare("UPDATE `users` SET `profilepicture` = :profilepicture WHERE `id` = :id");

                $statement->bindValue(':id', $userId);
                $statement->bindValue(':profilepicture', $profilepicture);

                $statement->execute();

                header('location: usersettings.php');
        }

        public function updateUser()
        {
                $conn = Db::getInstance();
                $statement = $conn->prepare("UPDATE `users` SET `firstname` = :firstname, `lastname` = :lastname, `bio` = :bio, `senior` = :senior WHERE `id` = :id;");
                $statement->bindvalue(':firstname', $this->firstname);
                $statement->bindvalue(':lastname', $this->lastname);
                $statement->bindvalue(':bio', $this->bio);
                $statement->bindvalue(':id', $this->userId);
                $statement->bindvalue(':senior', $this->senior);
                return $statement->execute();

        }

        public static function changeCurrentPassword($currentpassword, $newpassword, $newpassword2, $id){
            $conn = Db::getInstance();
                $sql = "SELECT * FROM `users` WHERE `id` = '$id';";
                $statement = $conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetch();

                $hash = $result["password"];
                if (password_verify($currentpassword, $hash)) {
                        if ($newpassword == $newpassword2) {
                                $options = [
                                        'cost' => 12
                                ];
                                $password = password_hash($newpassword, PASSWORD_BCRYPT, $options);
                                $statement2 = $conn->prepare("UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = '$id';");
                                $statement2->execute();
                        } else {
                                throw new Exception("Nieuw wachtwoord komt niet overeen met herhaald wachtwoord.");
                        }
                } else {
                        throw new Exception("Huidig wachtwoord is incorrect");
                }
        }

        public function updateTitle()
        {
                $conn = Db::getInstance();
                $statement = $conn->prepare("UPDATE `users` SET `title` = :title WHERE `id` = :id;");
                $statement->bindvalue(':title', $this->title);
                $statement->bindvalue(':id', $this->userId);
                return $statement->execute();

        }

        public static function deleteUser($sessionId, $password) { 
            $conn = Db::getInstance();
            $sql = "SELECT * FROM `users` WHERE `id` = '$sessionId';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch();
            $hash = $result["password"];
            if (password_verify($password, $hash)) {
                    $statement = $conn->prepare("DELETE FROM `users` WHERE `id` = :id");
                    $statement->bindValue(":id", $sessionId);
                    $statement->execute();
    }
             else {
                    throw new Exception("Wachtwoord is onjuist");
            }
            
             
 }

        public static function getTitleByUserId($id) {
            $conn = Db::getInstance();
            $statement = $conn->prepare('SELECT * FROM users INNER JOIN titles ON titles.id = users.title WHERE users.id = :id;');
            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }

        public static function getTitleIdFromId($id)
        {
            $conn = Db::getInstance();
            $sql = "SELECT title FROM `users` WHERE `id` = '$id';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function getAllUsersSearch($filter)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `users` WHERE `firstname` LIKE '%$filter%' OR  `lastname` LIKE '%$filter%';");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllUsers()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `users`");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }
    
    }

    

    

?>