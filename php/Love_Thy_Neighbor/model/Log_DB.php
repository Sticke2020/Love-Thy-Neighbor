<?php
require_once("Log.php");


class LogDB {

public static function createLog($log) {
    $userId = $log->getUserId();
    $actionTypeId = $log->getActionTypeId();

    $db = DataBase::getDB();

    $query = 'INSERT INTO log
            (user_id, action_type_id)
            VALUES
            (:userId, :actionTypeId)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':actionTypeId', $actionTypeId);
    $statement->execute();
    $statement->closeCursor();
}

public static function getLogs() {
    $db = DataBase::getDB();
}

public static function deleteLogs($userId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM log
            WHERE user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

public static function getActionType() {

}

}