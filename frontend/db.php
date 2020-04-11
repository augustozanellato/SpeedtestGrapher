<?php
class Database
{
    private static $instance;

    private function __construct(){

    }

    public static function getInstance(): PDO
    {
        if (is_null(static::$instance)){
            $config = [];
            $fh = fopen(__DIR__ . "/../db.config", "r");
            while($line = fgets($fh)){
                $line = explode("=", $line);
                $key = array_shift($line);
                $value = trim(implode("=", $line), " \t\n\r\0\x0B\"");
                $config[$key] = $value;
            }
            fclose($fh);
            unset($fh);
            $host = 'db';
            $db   = $config["MYSQL_DATABASE"];
            $user = $config["MYSQL_USER"];
            $pass = $config["MYSQL_PASSWORD"];
            $charset = 'utf8mb4';
            
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            ];
            static::$instance = new PDO($dsn, $user, $pass, $options);
        }
        return static::$instance;
    }
}
