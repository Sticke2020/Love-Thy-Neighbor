<?php
require_once("Request.php");
require_once("Image.php");
require_once("Image_DB.php");

class RequestDB {

public static function getRequests() {
    $db = DataBase::getDB();

    $query = 'SELECT 
                r.id AS request_id, 
                r.user_id, 
                u.username,
                r.title, 
                r.body, 
                r.request_status_type_id,
                r.date_created, 
                r.date_updated, 
                ri.id AS request_image_id, 
                ri_img.file_name AS request_file_name,
                ri_img.file_url AS request_file_url,
                ui.id AS user_image_id,
                ui.file_name AS user_file_name,
                ui.file_url AS user_file_url
            FROM request r
            LEFT JOIN request_image ri ON r.id = ri.request_id
            LEFT JOIN image ri_img ON ri.image_id = ri_img.id
            LEFT JOIN user u ON u.id = r.user_id
            LEFT JOIN image ui ON ui.id = u.profile_image_id
            ORDER BY r.date_created DESC';

    $statement = $db->prepare($query);
    $statement->execute();

    $requests = array();
    foreach ($statement as $row) {
        // ensures that requests arent duplicated since the sql will return duplicate requests
        // that contain different images since 1 request can have multiple images
        $requestId = $row['request_id'];

        // if the requestId is not a request object create the request otherwise dont
        if (!isset($requests[$requestId])) {
            $request = new Request();
            $request->setId($row['request_id']);
            $request->setUserId($row['user_id']);
            $request->setTitle($row['title']);
            $request->setBody($row['body']);
            $request->setUserImage($row['user_file_url'] ?? 'https://api.dicebear.com/9.x/initials/svg?seed=' . urlencode($row['username']));
            $request->setUserName($row['username']);
            $request->setRequestStatusTypeId($row['request_status_type_id']);
            $request->setDateCreated($row['date_created']);
            $request->setDateUpdated($row['date_updated']);

            $requests[$requestId] = $request;
        }

        // need to check for duplicates before adding images to array
            $request = $requests[$requestId];
            $existingImageIds = array();
            $imagesAdded = $requests[$requestId]->getImages();

            foreach ($imagesAdded as $img) {
                $existingImageIds[] = $img->getId(); // add each image's ID to the array
            }

        // Adds the image to the request if the image is not already in the array of images for the request
        if (!empty($row['request_image_id']) && !in_array($row['request_image_id'], $existingImageIds)) {
            $image = new Image();
            $image->setId($row['request_image_id']);
            $image->setFileName($row['request_file_name']);
            $image->setFileUrl($row['request_file_url']);

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

public static function getRequestById($id) {
    $db = DataBase::getDB();

    $query = 'SELECT r.id AS request_id, r.user_id, r.title, r.body, r.request_status_type_id,
                    r.date_created, r.date_updated, ri.id AS request_image_id, i.id AS image_id, i.file_name, i.file_url 
                FROM request r 
                    LEFT JOIN request_image ri ON r.id = ri.request_id 
                    LEFT JOIN image i on ri.image_id = i.id 
                WHERE r.id = :id';

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $request = null;
    foreach ($statement as $row) {

        if ($request === null) {
            $request = new Request();
            $request->setId($row['request_id']);
            $request->setUserId($row['user_id']);
            $request->setTitle($row['title']);
            $request->setBody($row['body']);
            $request->setRequestStatusTypeId($row['request_status_type_id']);
            $request->setDateCreated($row['date_created']);
            $request->setDateUpdated($row['date_updated']);
        }

        if ($row['image_id'] !== null) {
            $image = new Image();
            $image->setId($row['image_id']);
            $image->setFileName($row['file_name']);
            $image->setFileUrl($row['file_url']);

            $request->addImage($image);
        } 
    }
    return $request;
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

public static function updateRequest($requestId, $title, $body) {
    $db = DataBase::getDB();
    $query = 'UPDATE request
                SET 
                    title = :title, body = :body, date_updated = NOW()
                WHERE
                    id = :requestId';

    $statement = $db->prepare($query);
    $statement->bindValue(':requestId', $requestId);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':body', $body);
    $statement->execute();
    $statement->closeCursor();
}

// 2 = fulfilled, 1 = unfulfilled
public static function markRequestFulfilled($requestId) {
    $db = DataBase::getDB();

    $query = 'UPDATE request
                SET
                    request_status_type_id = 2
                WHERE id = :requestId';

    $statement = $db->prepare($query);
    $statement->bindValue(':requestId', $requestId);
    $statement->execute();
    $statement->closeCursor();
}

public static function deleteRequest($requestId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM request WHERE id = :requestId';

    $statement = $db->prepare($query);
    $statement->bindValue(':requestId', $requestId);
    $statement->execute();
    $statement->closeCursor();
}

}