<?php 
    include_once(__DIR__ . "/Db.php");

    class Title
    {
        private $titleId;
        private $userId;
        private $title;
        private $badge;
    

        public function getTitle()
        {
            return $this->title;
        }

        public function setTitle($title)
        {
            $this->title = $title;
            return $this;
        }


        public function setTitleId($titleId) {
            $this->titleId = $titleId;
            return $this;
        }
        
        public function getTitleId() {
            return $this->titleId;
        }

        public function setBadge($badge) {
            $this->badge = $badge;
            return $this;
        }
        
        public function getBadge() {
            return $this->badge;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        public function setUserId($userId)
        {
            $this->userId = $userId;
            return $this;
        }


        public static function getAllTitles()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `titles`;");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }


        public static function getTitleById($titleId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `title` WHERE `id` = :id");
            $statement->bindValue(':id', $titleId);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }


        public function updateTitle()
        {
                $conn = Db::getInstance();
                $statement = $conn->prepare("UPDATE `badge` SET `title_id` = :titleId, `user_id` = :userId;");
                $statement->bindvalue(':userId', $this->userId);
                $statement->bindvalue(':titleId', $this->titleId);
                return $statement->execute();
        }


        



    }

?>