<?php
require_once("Image.php");


class ImageDB {

public static function getImageById($imageId) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM image WHERE id = :imageId';

    $statement = $db->prepare($query);
    $statement->bindValue(':imageId', $imageId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if (!$row) {
        return null; 
    }

    $image = new Image();
    $image->setId($row['id']);
    $image->setUserId($row['user_id']);
    $image->setFileName($row['file_name']);
    $image->setFileUrl($row['file_url']);
        
    return $image;
}

public static function getImagesByRequestId($requestId) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM image i
                JOIN request_image ri
                ON i.id = ri.image_id
             WHERE ri.request_id = :requestId';

    $statement = $db->prepare($query);
    $statement->bindValue(':requestId', $requestId);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    $images = [];
    foreach ($results as $row) {
        $image = new Image();
        $image->setId($row['image_id']);
        $image->setFileName($row['file_name']);

        $images[] = $image;
    }
    return $images;
}

public static function insertImage($image) {
    $userId = $image->getUserId();
    $fileName = $image->getFileName();
    $fileUrl = $image->getFileUrl();
    $fileSize = $image->getFileSizeBytes();

    $db = DataBase::getDB();

    $query = 'INSERT INTO image
                (user_id, file_name, file_url, file_size_bytes)
            VALUES
                (:userId, :fileName, :fileUrl, :fileSize)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':fileName', $fileName);
    $statement->bindValue(':fileUrl', $fileUrl);
    $statement->bindvalue(':fileSize', $fileSize);
    $statement->execute();

    $imageId = $db->lastInsertId();
    return $imageId;
}

public static function uploadProfileImage($uploadDirectory, $userId) {
    $db = DataBase::getDB();

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $fileSize = $_FILES['image']['size'];

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $name =  bin2hex(random_bytes(16))  . '.' . $extension;

        $destination = $uploadDirectory . $name;

        $fileUrl = 'http://localhost:8082/uploads/' . $name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $image = new Image();

            $image->setFileName($name);
            $image->setFileUrl($fileUrl);
            $image->setUserId($userId);
            $image->setFileSizeBytes($fileSize);

            $imageId = ImageDB::insertImage($image);
            UserDB::setUserProfilePic($userId, $imageId);
        }
    }
}

public static function insertRequestImage($imageId, $requestId) {
    $db = DataBase::getDB();

    $query = 'INSERT INTO request_image
                (request_id, image_id)
            VALUES
                (:requestId, :imageId)';

    $statement = $db->prepare($query);
    $statement->bindValue(':requestId', $requestId);
    $statement->bindValue(':imageId', $imageId);
    $statement->execute();
    $statement->closeCursor();
}

public static function uploadRequestImages($requestId, $userId) {
    $uploadDirectory = '/var/www/uploads/';

    $db = DataBase::getDB();

    if (!empty($_FILES['images']['name'][0])) {
        $totalFiles = count($_FILES['images']['name']);

        for ($i = 0; $i  < $totalFiles; $i++) {

            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {

                $fileSize = $_FILES['images']['size'][$i];

                $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);

                $name =  bin2hex(random_bytes(16))  . '.' . $extension;

                $destination = $uploadDirectory . $name;

                $fileUrl = 'http://localhost:8082/uploads/' . $name;

                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $destination)) {
                    $image = new Image();

                    $image->setRequestId($requestId);
                    $image->setFileName($name);
                    $image->setFileUrl($fileUrl);
                    $image->setUserId($userId);
                    $image->setFileSizeBytes($fileSize);

                    $imageId = ImageDB::insertImage($image);

                    ImageDB::insertRequestImage($imageId, $requestId);
                }
            }
        }
    }

}

public static function deleteImageById($imageId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM image WHERE id = :imageId';

    $statement = $db->prepare($query);
    $statement->bindValue(':imageId', $imageId);
    $statement->execute();

    if ($statement->rowCount() === 0) {
        throw new Exception("No image deleted");
    }

    $statement->closeCursor();
}

public static function deleteRequestImageTableEntry($imageId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM request_image 
                WHERE image_id = :imageId';

    $statement = $db->prepare($query);
    $statement->bindValue(':imageId', $imageId);
    $statement->execute();
    $statement->closeCursor();
}

public static function deleteImageFromImageServer($imageId, $image) {
    $image = $image;
    $imageId = $imageId;
    $fileName = null;
    $path = null;
    if ($image === null) {
        $image = ImageDB::getImageById($imageId);
        $fileName = $image->getFileName();
        $path = '/var/www/uploads/' . $fileName;
    }
    else {
        $fileName = $image->getFileName();
        $path = '/var/www/uploads/' . $fileName;
    }

    if (file_exists($path)) {
        if (!unlink($path)) {
            throw new Exception("Failed to delete image file" . $path);
        }
    }
}

}