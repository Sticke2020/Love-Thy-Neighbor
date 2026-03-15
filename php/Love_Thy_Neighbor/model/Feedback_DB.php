<?php
require_once("Feedback.php");


class FeedbackDB {
/*
public static function getFeedback() {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM feedback';

    $statement = $db->prepare($query);
    $statement->execute();

    $feedbackAll = array();
    foreach ($statement as $row) {
        $feedback = new Feedback();
        $feedback->setID($row['id']);
        $feedback->setSenderId($row['author_id']);
        $feedback->setReceiverId($row['target_user_id']);
        $feedback->setComment($row['comment']);
        $feedback->setDateCreated($row['date_created']);

        $feedbackAll[] = $feedback;
    }
    return $feedbackAll;
}
*/

public static function getFeedbackByUserId($userId) {
    $db = DataBase::getDB();

    $query = 'SELECT f.*, u.username, u.profile_image_id, i.file_url
                FROM feedback f
                JOIN user u ON f.author_id = u.id
                JOIN image i ON u.profile_image_id = i.id
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
        $feedback->setSenderImage($row['file_url']);
        $feedback->setReceiverId($row['target_user_id']);
        $feedback->setComment($row['comment']);
        $feedback->setDateCreated($row['date_created']);

        $feedbackAll[] = $feedback;
    }
    return $feedbackAll;
}


}