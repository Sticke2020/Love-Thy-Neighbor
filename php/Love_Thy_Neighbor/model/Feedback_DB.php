<?php
require_once("Feedback.php");


class FeedbackDB {

public static function getFeedbackByUserId($userId) {
    $db = DataBase::getDB();

    $query = 'SELECT f.*, u.username, u.profile_image_id, i.file_url
                FROM feedback f
                JOIN user u ON f.author_id = u.id
                LEFT JOIN image i ON u.profile_image_id = i.id
                WHERE f.target_user_id = :userId
                ORDER BY f.date_created DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $feedbackAll = array();
    foreach ($statement as $row) {
        $feedback = new Feedback();
        $feedback->setID($row['id']);
        $feedback->setSender($row['username']);
        $feedback->setSenderId($row['author_id']);
        $feedback->setSenderImage($row['file_url'] ?? 'https://api.dicebear.com/9.x/initials/svg?seed=' . urlencode($row['username']));
        $feedback->setReceiverId($row['target_user_id']);
        $feedback->setComment($row['comment']);
        $feedback->setDateCreated($row['date_created']);

        $feedbackAll[] = $feedback;
    }
    return $feedbackAll;
}

public static function createFeedback($feedback) {
    $db = DataBase::getDB();

    $senderId = $feedback->getSenderId();
    $receiverId = $feedback->getReceiverId();
    $comment = $feedback->getComment();

    $query = 'INSERT INTO feedback
            (author_id, target_user_id, comment)
        VALUES
            (:senderId, :receiverId, :comment)';

    $statement = $db->prepare($query);
    $statement->bindValue(':senderId', $senderId);
    $statement->bindValue(':receiverId', $receiverId);
    $statement->bindValue(':comment', $comment);
    $statement->execute();
    $statement->closeCursor();
}

// Deletes all feedback left and received by the user
public static function deleteFeedbackByUserId($userId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM feedback
                WHERE target_user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();

    $query2 = 'DELETE FROM feedback
                WHERE author_id = :userId';

    $statement = $db->prepare($query2);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

public static function deleteFeedbackById($feedbackId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM feedback
                WHERE id = :feedbackId';

    $statement = $db->prepare($query);
    $statement->bindValue(':feedbackId', $feedbackId);
    $statement->execute();
    $statement->closeCursor();
}

}