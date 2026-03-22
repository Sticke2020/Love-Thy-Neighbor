<?php
require_once("Message.php");


class MessageDB {

public static function createMessage($message) {
    $db = Database::getDB();

    $senderId = $message->getSenderId();
    $receiverId = $message->getReceiverId();
    $body = $message->getBody();

    $query = 'INSERT INTO message
                (sender_id, receiver_id, body)
                VALUES
                (:senderId, :receiverId, :body)';

    $statement = $db->prepare($query);
    $statement->bindValue(':senderId', $senderId);
    $statement->bindValue(':receiverId', $receiverId);
    $statement->bindValue(':body', $body);
    $statement->execute();
    $statement->closeCursor();

}

public static function getMessagesByUserId($userId) {
    $db = Database::getDB();

    $query = 'SELECT m.*, u.username 
                FROM message m 
                JOIN user u ON m.sender_id = u.id
                WHERE receiver_id = :userId
                ORDER BY date_created DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $messages = array();
    foreach ($statement as $row) {
        $message = new Message();
        $message->setID($row['id']);
        $message->setSenderId($row['sender_id']);
        $message->setSender($row['username']);
        $message->setReceiverId($row['receiver_id']);
        $message->setBody($row['body']);
        $message->setDateCreated($row['date_created']);
        $message->setIsRead($row['is_read']);
        
        $messages[] = $message;
    }
    return $messages;
}

public static function getSentMessagesByUserId($userId) {
    $db = Database::getDB();

    $query = 'SELECT m.*, u.username 
                FROM message m 
                JOIN user u ON m.receiver_id = u.id
                WHERE sender_id = :userId
                ORDER BY date_created DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $messages = array();
    foreach ($statement as $row) {
        $message = new Message();
        $message->setID($row['id']);
        $message->setSenderId($row['sender_id']);
        $message->setReceiverId($row['receiver_id']);
        $message->setReceiver($row['username']);
        $message->setBody($row['body']);
        $message->setDateCreated($row['date_created']);
        $message->setIsRead($row['is_read']);
        
        $messages[] = $message;
    }
    return $messages;
}

public static function getMessageByMessageId($messageId) {
    $db = Database::getDB();

    $query = 'SELECT m.*, u.username 
                FROM message m 
                JOIN user u ON m.sender_id = u.id
                WHERE m.id = :messageId';

    $statement = $db->prepare($query);
    $statement->bindValue(':messageId', $messageId);
    $statement->execute();
    $row = $statement->fetch();

    $message = new Message();
    $message->setID($row['id']);
    $message->setSenderId($row['sender_id']);
    $message->setSender($row['username']);
    $message->setReceiverId($row['receiver_id']);
    $message->setBody($row['body']);
    $message->setDateCreated($row['date_created']);
    $message->setIsRead($row['is_read']);
        
    return $message;
}


}