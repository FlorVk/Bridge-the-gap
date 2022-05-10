<?php 
    include_once(__DIR__ . "/Db.php");

    class USer
    {
        private $postId;
        private $title;
        private $description;
        private $userID;
        private $timePosted;
    

        public function getTitle()
        {
            return $this->title;
        }

        public function setTitle($title)
        {
            if (empty($title)) {
                throw new Exception("title cant be empty");
            }
            $this->title = $title;

            return $this;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function setDescription($description)
        {
            if (empty($description)) {
                throw new Exception("Description cant be empty");
            }
            $this->description = $description;
            return $this;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
            return $this;
        }
        
        public function getUserId() {
            return $this->userId;
        }

        public function setPostId($postId) {
            $this->postId = $postId;
            return $this;
        }
        
        public function getPostId() {
            return $this->postId;
        }

        public function getTimePosted(){
            return $this->timePosted;
        }

        public function setTimePosted($timePosted){
            $this->timePosted = $timePosted;

            return $this;
        }
    }

?>