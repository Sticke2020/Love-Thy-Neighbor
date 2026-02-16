<?php
require_once("Request.php");

class RequestDB {

public static function getRequestsByUserId($ID) {
    $db = DataBase::getDB();

    $query = 'SELECT r.id AS request_id, r.user_id, r.title, r.body, r.request_status_type_id,
                    r.date_created, r.date_updated, ri.id AS request_image_id, i.file_name, i.file_url 
                FROM request r 
                    JOIN request_image ri ON r.id = ri.request_id 
                    JOIN image i on ri.image_id = i.id 
                WHERE r.user_id = :ID';

    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();

    $requests = array();
    foreach ($statement as $row) {
        $request = new Request();
        $request->setId($row['request_id']);
        $request->setUserId($row['user_id']);
        $request->setTitle($row['title']);
        $request->setBody($row['body']);
        $request->setRequestStatusTypeId($row['request_status_type_id']);
        $request->setDateCreated($row['date_created']);
        $request->setDateUpdated($row['date_updated']);
        $request->setRequestImageId($row['request_image_id']);
        $request->setFileName($row['file_name']);
        $request->setFileUrl($row['file_url']);

        $requests[] = $request;
    }
    return $requests;
}

public static function createRequest($request) {
    $userId =  $request->getUserId();
    $title = $request->getTitle();
    $body = $request->getBody();
    $requestStatusTypeId = $request->getRequestStatusTypeId();

    $db = DataBase::getDB();

    $query = 'INSERT INTO request
                (user_id, title, body, request_status_type_id)
            VALUES 
                (:userId, :title, :body, :requestStatusTypeId)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':body', $body);
    $statement->bindValue(':requestStatusTypeId', $requestStatusTypeId);
    $statement->execute();
    
    $requestId = $db->lastInsertId();
    return $requestId;
}

}