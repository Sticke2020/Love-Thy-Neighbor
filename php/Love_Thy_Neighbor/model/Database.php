<?php
class DataBase {

    // dsn = Data Source Name tells PDO how to connect
    private static $dsn = 'mysql:host=db;dbname=love_thy_neighbor';
    private static $username = 'mgs_user';
    private static $dbpassword = 'pa55word';
    private static $db;  // Holds the PDO connection object

    public static function getDB () {
        // Checks if a DB connection already exists, if not it creates one
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$dbpassword);
                // Throw exceptions if something goes wrong
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../errors/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
}