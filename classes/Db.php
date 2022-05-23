<?php
abstract class Db
{
    private static $conn;

    public static function getInstance()
    {
        if (self::$conn != null) {
            // connection found, return connection
            return self::$conn;
        } else {
            $config = parse_ini_file("config/config.ini");
            self::$conn = new PDO(
                'mysql:host=' . $config['host'] . 
                ';dbname=' . $config['name'], 
                $config['user'], 
                $config['password']);
            return self::$conn;
        }
    }
}