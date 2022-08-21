<?php 
    include_once(__DIR__ . "/Db.php");

    class Post
    {
        private $postId;
        private $title;
        private $description;
        private $userID;
        private $timePosted;
        private $category;
        private $imgPath;
        private $category2;
    

        public function getTitle()
        {
            return $this->title;
        }

        public function setTitle($title)
        {
            if (empty($title)) {
                throw new Exception("De post moet een titel hebben.");
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
                throw new Exception("Post moet een inhoud hebben.");
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

        public function setCategory($category) {
            $this->category = $category;
            return $this;
        }
        
        public function getCategory() {
            return $this->category;
        }

        public function setCategory2($category2) {
            $this->category2 = $category2;
            return $this;
        }
        
        public function getCategory2() {
            return $this->category2;
        }

        public function setImage($imgPath) {
            $this->imgPath = $imgPath;
            return $this;
        }
        
        public function getImage() {
            return $this->imgPath;
        }



        public function uploadPost()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `posts` (`title`, `description`, `user_id`, `time_posted`, `img_path`, `category`, `category2`) VALUES (:title, :description, :user_id, :time_posted, :imgPath, :category, :category2)");
            $statement->bindValue(':title', $this->title);
            $statement->bindValue(':description', $this->description);
            $statement->bindValue(':user_id', $this->userId);
            $statement->bindValue(':imgPath', $this->imgPath);
            $statement->bindValue(':category', $this->category);
            $statement->bindValue(':category2', $this->category2);
            $statement->bindValue(':time_posted', $this->timePosted);
            $statement->execute();

            header('location: index.php');
        }

        public static function getUserByPostId($postId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `users` INNER JOIN `posts` ON users.id = posts.user_id WHERE posts.id = :postId");
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
            $limit = 20;
            $offset = ($page - 1) * $limit;


            // totaal aantal pagina's nemen
            $sql = "SELECT * FROM `posts` WHERE `title` LIKE '%$filter%' OR  `description` LIKE '%$filter%';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllPostsLimitCategory($category)
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
            $sql = "SELECT * FROM `posts` WHERE `category` LIKE '%$category%' ";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllPostsLimitCategory2($category2)
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
            $sql = "SELECT * FROM `posts` WHERE `category2` LIKE '%$category2%' ";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllPostsLimitCategories($category, $category2)
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
            $sql = "SELECT * FROM `posts` WHERE `category` LIKE '%$category%' AND `category2` LIKE '%$category2%' ";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getAllTop()
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
            $sql = "SELECT * FROM `posts` WHERE tips >= 2 ORDER BY `time_posted` DESC LIMIT $offset, $limit;";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getPost($postId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `posts` WHERE `id` = :id");
            $statement->bindValue(':id', $postId);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }

        public static function getPostsByUserId($userId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `posts` WHERE `user_id` = :user_Id");
            $statement->bindValue(':user_Id', $userId);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }


        public function updatePost()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE`posts` SET `title` = :title, `description` = :description, `category` = :category WHERE `posts`.`id` = :id;");
            $statement->bindValue(':title', $this->title);
            $statement->bindValue(':description', $this->description);
            $statement->bindValue(':id', $this->postId);
            $statement->bindValue(':category', $this->category);
            $statement->execute();

        }

        public function updatePostPicture($postPicture, $postId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE `posts` SET `img_path` = :imgPath WHERE `posts`.`id` = :id;");
            $statement->bindValue(":id", $postId);
            $statement->bindValue(":imgPath", $postPicture);

            $statement->execute();

            //header('location: updateproject.php');
        }

        public static function deletePostByPostId($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM posts WHERE id = :post_id");
            $statement->bindValue(':post_id', $id);
            $statement->execute();
        }

        public static function addTip($id){

            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE posts SET tips = tips + 1 WHERE id = :postId");
            $statement->bindValue(':postId', $id);
            $statement->execute();
        }

        public static function removeTip($id){

            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE posts SET tips = tips - 1 WHERE id = :postId");
            $statement->bindValue(':postId', $id);
            $statement->execute();
        }



    }

?>