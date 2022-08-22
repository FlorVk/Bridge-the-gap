<?php
include_once(__DIR__ . "/Db.php");
    class Chat
    {
        private $message;
        private $outgoing;
        private $incoming;

        

        /**
         * Get the value of text
         */
        public function getMessage()
        {
            return $this->message;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setMessage($message)
        {
            if (empty($message)) {
                throw new Exception("Plaats een bericht.");
            }
            $this->message = $message;
            return $this;
        }

        /**
         * Get the value of text
         */
        public function getOutgoing()
        {
            return $this->outgoing;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setOutgoing($outgoing)
        {
            $this->outgoing = $outgoing;

            return $this;
        }

        /**
         * Get the value of text
         */
        public function getIncoming()
        {
            return $this->incoming;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */
        public function setIncoming($incoming)
        {
            $this->incoming = $incoming;

            return $this;
        }

        public static function getAllMessages($outgoing, $incoming)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `messages` WHERE outgoing = $outgoing AND incoming = $incoming OR outgoing = $incoming AND incoming = $outgoing ORDER BY id ASC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

        public static function getAllChats($incoming)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `messages` WHERE  incoming = $incoming OR outgoing = $incoming");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }
        

        public static function addMessage($incoming, $outgoing, $message)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `messages` (`incoming`, `outgoing`, `message`) VALUES (:incoming, :outgoing, :chat)");
            $statement->bindValue(':incoming', $incoming);
            $statement->bindValue(':outgoing', $outgoing);
            $statement->bindValue(':chat', $message);
            $result = $statement->execute();
            return $result;

        }

        public function sendMessage() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `messages` (`incoming`, `outgoing`, `message`) VALUES (:incoming, :outgoing, :message)");
            $statement->bindValue(":outgoing", $this->outgoing);
            $statement->bindValue(":incoming", $this->incoming);
            $statement->bindValue(":incoming", $this->message);
            $statement->execute();
        }

        public function countMessages(){
            $conn = Db::getInstance();
            $statement = $conn->prepare('SELECT COUNT(*)FROM comments WHERE post_id = :postId');
            $statement->bindValue(":postId", );
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
