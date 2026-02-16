<?php
require_once("Image.php");

class ImageDB {

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

public static function uploadRequestImages($requestId, $uploadDirectory, $userId) {
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

}