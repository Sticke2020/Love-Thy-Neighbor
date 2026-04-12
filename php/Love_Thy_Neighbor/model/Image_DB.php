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
// Uploads the user profile pic to the image server and stores the image info in the DB
public static function uploadProfileImage($uploadDirectory, $userId) {

    // Checks if the file uploaded sucessfully (to a temporary folder) without errors
    // In this case image contains attributes for the Image being uploaded like name, size, error and type
    // error contains the upload status code 0 = success, anything else is some sort of error
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {

        // Gets the filesize in bytes
        $fileSize = $_FILES['image']['size'];

        // Gets the file extension
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Creates a unique 16 byte filename to prevent naming conflicts
        $name =  bin2hex(random_bytes(16))  . '.' . $extension;

        // Where the file is saved on the image server
        $destination = $uploadDirectory . $name;

        // The url used to access the image in the browser
        $fileUrl = 'http://localhost:8082/uploads/' . $name;

        // This moves file from temp storage to final destination and creates the Image object if 
        // the file was moved from its original temp location to its final destination successfully
        // If move_uploaded_file is not called the file stored temporarily will be deleted and lost
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $image = new Image();

            $image->setFileName($name);
            $image->setFileUrl($fileUrl);
            $image->setUserId($userId);
            $image->setFileSizeBytes($fileSize);

            // Image Id is returned from the insertImage method
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

// For uploading 1 or more images for user requests
public static function uploadRequestImages($requestId, $userId) {

    // Location on the server where images will be stored
    $uploadDirectory = '/var/www/uploads/';

    // Checks to make sure index 0 in the images array is not empty
    // If the array is not empty it uploads the image files
    if (!empty($_FILES['images']['name'][0])) {

        // Counts the uploaded files 
        $totalFiles = count($_FILES['images']['name']);

        // Loops through the images array 
        for ($i = 0; $i  < $totalFiles; $i++) {

            // Checks if file at index $i was uploaded without errors
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {

                // Gets the file size
                $fileSize = $_FILES['images']['size'][$i];

                // Gets the file extension
                $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);

                // Creates a unique 16 byte name for the file
                $name =  bin2hex(random_bytes(16))  . '.' . $extension;

                // Location the file will be stored on the image server
                $destination = $uploadDirectory . $name;

                // url used by browser to display the image
                $fileUrl = 'http://localhost:8082/uploads/' . $name;

                // moves the file at index $i from temp storage to final destination on the image server
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $destination)) {
                    $image = new Image();

                    $image->setRequestId($requestId);
                    $image->setFileName($name);
                    $image->setFileUrl($fileUrl);
                    $image->setUserId($userId);
                    $image->setFileSizeBytes($fileSize);

                    // Image Id is returned by insertImage method
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

// $image can be null 
public static function deleteImageFromImageServer($imageId, $image) {
    $fileName = null;
    $path = null;

    // Gets image if imageId was provided and image was not
    if ($image === null) {
        $image = ImageDB::getImageById($imageId);
    }
    
    $fileName = $image->getFileName();

    // File path on server
    $path = '/var/www/uploads/' . $fileName;
    
    // Checks that the file actually exists with the file path givin
    if (file_exists($path)) {
        // unlink() deletes the file at the givin path, if it fails is throws the new exception
        if (!unlink($path)) {
            throw new Exception("Failed to delete image file" . $path);
        }
    }
}

}