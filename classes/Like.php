<?php 
    class Like {
        private $postId;
        private $userId;
        private $isLiked;

        public function setPostId($postId) {
            $this->postId = $postId;
            return $this;
        }
        
        public function getPostId() {
            return $this->postId;
        }


        public function setUserId($userId) {
            $this->userId = $userId;
            return $this;
        }
        
        public function getUserId() {
            return $this->userId;
        }

        public function setIsLiked($isLiked) {
            $this->isLiked = $isLiked;
            return $this;
        }
        
        public function getIsLiked() {
            return $this->isLiked;
        }


        public function likePost() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `likes` (`post_id`, `user_id`) VALUES (:postId, :userId)");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
        }

        public function unlikePost() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM `likes` WHERE `post_id` = :postId AND `user_id` = :userId");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
        }

        public static function getAll($postId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM likes INNER JOIN users ON users.id = likes.user_id WHERE post_id = :postId");
            $statement->bindValue(":postId", $postId);
            $result = $statement->execute();
            $allLikes = $statement->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($result);
            return $allLikes;
        }

        public static function checkLiked($userId, $postId) {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM likes WHERE post_id = :postId AND user_id = :userId");
            $statement->bindValue(":postId", $postId);
            $statement->bindValue(":userId", $userId);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
                
            }
            else {
                 return 2;
               
            }

        }

        public static function checkTipped($userId, $postId) {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM tips WHERE post_id = :postId AND user_id = :userId");
            $statement->bindValue(":postId", $postId);
            $statement->bindValue(":userId", $userId);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
                
            }
            else {
                 return 2;
               
            }

        }

        public function tipPost() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `tips` (`post_id`, `user_id`) VALUES (:postId, :userId)");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
        }

        public function untipPost() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM `tips` WHERE `post_id` = :postId AND `user_id` = :userId");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
        }
    }