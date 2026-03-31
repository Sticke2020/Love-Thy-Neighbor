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

    $messageId = $db->lastInsertId();
    
    $query2 = "INSERT INTO message_user (message_id, user_id, folder, is_read, is_deleted)
               VALUES (:messageId, :userId, 'outbox', TRUE, FALSE)";
    $stmt2 = $db->prepare($query2);
    $stmt2->bindValue(':messageId', $messageId);
    $stmt2->bindValue(':userId', $senderId);
    $stmt2->execute();

    $query3 = "INSERT INTO message_user (message_id, user_id, folder, is_read, is_deleted)
               VALUES (:messageId, :userId, 'inbox', FALSE, FALSE)";
    $stmt3 = $db->prepare($query3);
    $stmt3->bindValue(':messageId', $messageId);
    $stmt3->bindValue(':userId', $receiverId);
    $stmt3->execute();

}

public static function getInboxMessagesByUserId($userId) {
    $db = Database::getDB();

    $query = "SELECT m.*, mu.folder, mu.is_read, mu.is_deleted, u.username AS sender_name
                FROM message m
                JOIN message_user mu ON m.id = mu.message_id
                JOIN user u ON m.sender_id = u.id
                WHERE mu.user_id = :userId
                AND mu.folder = 'inbox'
                AND mu.is_deleted = 0
                ORDER BY m.date_created DESC";

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $messages = array();
    foreach ($statement as $row) {
        $message = new Message();
        $message->setID($row['id']);
        $message->setSenderId($row['sender_id']);
        $message->setSender($row['sender_name']);
        $message->setReceiverId($row['receiver_id']);
        $message->setBody($row['body']);
        $message->setFolder($row['folder']);
        $message->setDateCreated($row['date_created']);
        $message->setIsRead($row['is_read']);
        $message->setIsDeleted($row['is_deleted']);
        
        $messages[] = $message;
    }
    return $messages;
}

public static function getOutboxMessagesByUserId($userId) {
    $db = Database::getDB();

    $query = "SELECT m.*, mu.folder, mu.is_read, mu.is_deleted, u.username AS receiver_name
                FROM message m
                JOIN message_user mu ON m.id = mu.message_id
                JOIN user u ON m.receiver_id = u.id
                WHERE mu.user_id = :userId
                AND mu.folder = 'outbox'
                AND mu.is_deleted = 0
                ORDER BY m.date_created DESC";

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $messages = array();
    foreach ($statement as $row) {
        $message = new Message();
        $message->setID($row['id']);
        $message->setSenderId($row['sender_id']);
        $message->setReceiverId($row['receiver_id']);
        $message->setReceiver($row['receiver_name']);
        $message->setBody($row['body']);
        $message->setFolder($row['folder']);
        $message->setDateCreated($row['date_created']);
        $message->setIsRead($row['is_read']);
        $message->setIsDeleted($row['is_deleted']);
        
        $messages[] = $message;
    }
    return $messages;
}

public static function getMessageByMessageId($messageId, $userId) {
    $db = Database::getDB();

    $query = 'SELECT m.*, mu.is_read, mu.folder, sender.username AS sender_name, receiver.username AS receiver_name
                FROM message m
                JOIN message_user mu ON m.id = mu.message_id
                JOIN user sender ON m.sender_id = sender.id
                JOIN user receiver ON m.receiver_id = receiver.id
                WHERE m.id = :messageId
                AND mu.user_id = :userId
                AND mu.is_deleted = 0';

    $statement = $db->prepare($query);
    $statement->bindValue(':messageId', $messageId);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $row = $statement->fetch();

    $message = new Message();
    $message->setId($row['id']);
    $message->setSenderId($row['sender_id']);
    $message->setSender($row['sender_name']);
    $message->setReceiverId($row['receiver_id']);
    $message->setBody($row['body']);
    $message->setDateCreated($row['date_created']);
    $message->setIsRead($row['is_read']);
        
    return $message;
}

public static function messageIsRead($messageId) {
    $db = DataBase::getDB();

    $query = "UPDATE message_user
                SET is_read = 1
                WHERE message_id = :messageId
                AND folder = 'inbox'";

    $statement = $db->prepare($query);
    $statement->bindValue(':messageId', $messageId);
    $statement->execute();
    $statement->closeCursor();
}

public static function hasUnreadMessages($userId) {
    $messages = MessageDB::getInboxMessagesByUserId($userId);
    $isValid = false;

    foreach ($messages as $message) {
        if ($message->getIsRead() == 0) {
            $isValid = true;
            return $isValid;
        }
    }

    return $isValid;
}

public static function softDeleteMessage($userId, $messageId) {
     $db = DataBase::getDB();

    $query = "UPDATE message_user
                SET is_deleted = 1
                WHERE user_id = :userId
                AND message_id = :messageId";

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':messageId', $messageId);
    $statement->execute();
    $statement->closeCursor();
}


}