<?php
include_once(__DIR__ . "/Db.php");
    class Comment
    {
        private $comment;
        private $postId;
        private $userId;

        

        /**
         * Get the value of text
         */
        public function getComment()
        {
            return $this->comment;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setComment($comment)
        {
            $this->comment = $comment;

            return $this;
        }

        /**
         * Get the value of text
         */
        public function getPostId()
        {
            return $this->postId;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setPostId($postId)
        {
            $this->postId = $postId;

            return $this;
        }

        /**
         * Get the value of text
         */
        public function getUserId()
        {
            return $this->userId;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setUserId($userId)
        {
            $this->userId = $userId;

            return $this;
        }

        public static function getAllComments()
        {
            
            $conn = Db::getInstance();
            $sql = "SELECT * FROM `comments` ORDER BY `date` ASC";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function getAll($postId) {
            $conn = Db::getInstance();
            $statement = $conn->prepare('SELECT * FROM users INNER JOIN comments ON users.id = comments.user_id WHERE post_id = :postId');
            $statement->bindValue(":postId", $postId);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function addComment()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `comments` (`post_id`, `user_id`, `comment`) VALUES (:postId, :userId, :comment)");
            $statement->bindValue(':postId', $this->postId);
            $statement->bindValue(':userId', $this->userId);
            $statement->bindValue(':comment', $this->comment);
            $result = $statement->execute();
            return $result;

        }
    }
