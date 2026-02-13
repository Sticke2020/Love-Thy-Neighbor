<?php
class DataBase {

    private static $dsn = 'mysql:host=db;dbname=love_thy_neighbor';
    private static $username = 'mgs_user';
    private static $dbpassword = 'pa55word';
    private static $db;


    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$dbpassword);
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