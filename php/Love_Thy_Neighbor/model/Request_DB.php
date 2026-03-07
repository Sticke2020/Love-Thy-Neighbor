<?php
require_once("Request.php");
require_once("Image.php");
require_once("Image_DB.php");

class RequestDB {

public static function getRequests() {
    $db = DataBase::getDB();

    $query = 'SELECT r.id AS request_id, r.user_id, r.title, r.body, r.request_status_type_id,
                    r.date_created, r.date_updated, ri.id AS request_image_id, i.id AS image_id, i.file_name, i.file_url 
                FROM request r 
                    LEFT JOIN request_image ri ON r.id = ri.request_id 
                    LEFT JOIN image i on ri.image_id = i.id 
                ORDER BY r.date_created desc';

    $statement = $db->prepare($query);
    $statement->execute();

    $requests = array();
    foreach ($statement as $row) {

        $requestId = $row['request_id'];

        if (!isset($requests[$requestId])) {
            $request = new Request();
            $request->setId($row['request_id']);
            $request->setUserId($row['user_id']);
            $request->setTitle($row['title']);
            $request->setBody($row['body']);
            $request->setRequestStatusTypeId($row['request_status_type_id']);
            $request->setDateCreated($row['date_created']);
            $request->setDateUpdated($row['date_updated']);

            $requests[$requestId] = $request;
        }

        if (!empty($row['image_id'])) {
            $image = new Image();
            $image->setId($row['image_id']);
            $image->setFileName($row['file_name']);
            $image->setFileUrl($row['file_url']);

            $requests[$requestId]->addImage($image);
        } 
    }
    return $requests;
}

public static function getRequestsByUserId($ID) {
    $db = DataBase::getDB();

    $query = 'SELECT r.id AS request_id, r.user_id, r.title, r.body, r.request_status_type_id,
                    r.date_created, r.date_updated, ri.id AS request_image_id, i.id AS image_id, i.file_name, i.file_url 
                FROM request r 
                    LEFT JOIN request_image ri ON r.id = ri.request_id 
                    LEFT JOIN image i on ri.image_id = i.id 
                WHERE r.user_id = :ID
                ORDER BY r.id';

    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();

    $requests = array();
    foreach ($statement as $row) {

        $requestId = $row['request_id'];

        if (!isset($requests[$requestId])) {
            $request = new Request();
            $request->setId($row['request_id']);
            $request->setUserId($row['user_id']);
            $request->setTitle($row['title']);
            $request->setBody($row['body']);
            $request->setRequestStatusTypeId($row['request_status_type_id']);
            $request->setDateCreated($row['date_created']);
            $request->setDateUpdated($row['date_updated']);

            $requests[$requestId] = $request;
        }

        if (!empty($row['image_id'])) {
            $image = new Image();
            $image->setId($row['image_id']);
            $image->setFileName($row['file_name']);
            $image->setFileUrl($row['file_url']);

            $requests[$requestId]->addImage($image);
        } 
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