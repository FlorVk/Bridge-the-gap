<?php 
    include_once(__DIR__ . "/Db.php");

    class Post
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



        public function uploadPost()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO posts (title, description, user_id, time_posted) VALUES (:title, :description, :user_id, :time_posted)");
            $statement->bindValue(":title", $this->title);
            $statement->bindValue(":description", $this->description);
            $statement->bindValue(":user_id", $this->userId);
            $statement->bindValue(":time_posted", $this->timePosted);
            $statement->execute();
        }

        public static function getUserByPostId($postId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM users INNER JOIN posts ON users.id = posts.user_id WHERE posts.id = :postId");
            $statement->bindValue(':postId', $postId);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function getAllPostsLimit()
        {
            global $page;
            global $total_pages;

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $conn = Db::getInstance();

            // pagination 
            $limit = 6;
            $offset = ($page - 1) * $limit;


            // totaal aantal pagina's nemen
            $stmt = $conn->query("SELECT COUNT(*) FROM `posts`;");
            $total_results = $stmt->fetchColumn();
            $total_pages = ceil($total_results / $limit);
            $sql = "SELECT * FROM `posts` ORDER BY `time_posted` DESC LIMIT $offset, $limit;";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllPostsLimitFiltered($filter)
        {
            global $page;
            global $total_pages;

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $conn = Db::getInstance();

            // pagination 
            $limit = 6;
            $offset = ($page - 1) * $limit;


            // totaal aantal pagina's nemen
            $sql = "SELECT * FROM `posts` WHERE `title` LIKE '%$filter%' OR  `description` LIKE '%$filter%' ;";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }
    }

?>