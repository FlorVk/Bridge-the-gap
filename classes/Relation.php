<?php
    include_once(__DIR__ . "/Db.php");

    class Relation
    {

        private $relationId;
        private $fromId;
        private $toId;
        private $status;
        private $since;

        public function getRelationId()
        {
            return $this->relationId;
        }

        public function setRelationId($relationId)
        {
            $this->relationId = $relationId;
            return $this;
        }

        public function getFromId()
        {
            return $this->fromId;
        }

        public function setFromId($fromId)
        {
            $this->fromId = $fromId;
            return $this;
        }

        public function getToId()
        {
            return $this->toId;
        }

        public function setToId($toId)
        {
            $this->toId = $toId;
            return $this;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function setStatus($status)
        {
            $this->status = $status;
            return $this;
        }

        public function getSince()
        {
            return $this->since;
        }

        public function setSince($since)
        {
            $this->since = $since;
            return $this;
        }

        public static function checkFriends($fromId, $toId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM relations WHERE `status`='F' AND `from_id` = $fromId AND `to_id` = $toId");
            $statement->execute();
            $result = $statement->fetch();
            if ($result) {
                //echo "oeikes";
                return 1;
                
            }
            else {
                 //echo "foeikes";
                 return 2;
               
            }
        }

        public static function checkFriendsTo($fromId, $toId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM relations WHERE `status`='F' AND `to_id` = $toId AND `from_id` = $fromId");
            $statement->execute();
            $result = $statement->fetch();
            if ($result) {
                //echo "oeikes";
                return 1;
                
            }
            else {
                 //echo "moeikes";
                 return 2;
               
            }
        }

        public static function checkPendingFrom($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM relations WHERE `status`='P' AND `from_id` = $fromId AND `to_id` = $toId");
            $statement->execute();
            $result = $statement->fetch();
            if ($result) {
                //echo "stoeikes";
                return 1;
                
            }
            else {
                //echo "roeikes";
                return 2;
                
            }
        }

        public static function checkPendingTo($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM relations WHERE `status`='P' AND `to_id` = $toId AND `from_id` = $fromId");
            $statement->execute();
            $result = $statement->fetch();
            if ($result) {
                //echo "woeikes";
                return 1;
                
            }
            else {
                //echo "loeikes";
                return 2;
                
            }
        }

        public function addFriendRequest(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `relations` (`from_id`, `to_id`, `status`) VALUES (:fromId, :toId, 'P');");
            $statement->bindValue(":fromId", $this->fromId);
            $statement->bindValue(":toId", $this->toId);
            return $statement->execute();
        }

        public function acceptFriend($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE relations SET status = 'F' WHERE status = 'P' AND `from_id` = $fromId AND `to_id` = $toId");
            $statement->execute();
            return $statement->execute();
        }

        public function addFriend(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `relations` (`from_id`, `to_id`, `status`) VALUES (:fromId, :toId, 'F');");
            $statement->bindValue(":fromId", $this->fromId);
            $statement->bindValue(":toId", $this->toId);
            return $statement->execute();
        }

        public function cancelRequest($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM relations WHERE (`status`='P' AND `from_id` = $fromId AND `to_id` = $toId) OR (`status`='P' AND `to_id` = $toId AND `from_id` = $fromId)");
            $statement->execute();
            return $statement->execute();
        }

        public function unfriend($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM relations WHERE (`status`='F' AND `from_id` = $fromId AND `to_id` = $toId) OR (`status`='F' AND `to_id` = $toId AND `from_id` = $fromId)");
            $statement->execute();
            return $statement->execute();
        }

        public static function getPending($fromId, $toId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM `relations` WHERE (`status`='P' AND `from_id` = $fromId AND `to_id` = $toId)");
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }
    }