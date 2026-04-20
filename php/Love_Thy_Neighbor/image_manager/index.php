<?php

require_once('../model/database.php');
require_once('../model/Image_DB.php');
require_once('../model/Image.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Request_DB.php');
require_once('../model/Request.php');
require_once('../model/Utility.php');

if(session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 14;
    session_name('userSession');
    session_set_cookie_params($lifetime, '/');
    session_start();
}

$action = filter_input(INPUT_POST, 'action');
if ( $action == NULL) {
     $action = filter_input(INPUT_GET, 'action');
    if ( $action == NULL) {
         $action = 'Not-Set (Null)';
    }
}


switch ($action) {

    case 'add_profile_image':
        $userId = $_SESSION['userId'];
        include('image_profile.php');
        break;

    case 'upload_profile_image':
        $userId = filter_input(INPUT_POST, 'user_id');
        $user = UserDB::getUserById($userId);
        $profilePic = null;
        $profilePicId = null;

        if ($user->getProfileImageId()) {
            $profilePic = ImageDB::getImageById($user->getProfileImageId());
            $profilePicId = $profilePic->getId();
        }

        try {
            $db = DataBase::getDB();
            $db->beginTransaction();

            // Upload new profile pic
            $uploadDirectory = '/var/www/uploads/';
            ImageDB::uploadProfileImage($uploadDirectory, $userId);

            // Remove old profile pic 
            if ($profilePicId !== null) {
                ImageDB::deleteImageById($profilePicId);
                ImageDB::deleteImageFromImageServer($profilePicId, $profilePic);
            }

            $db->commit();
        }
        catch (Exception $e) {
            $db->rollBack();
            echo "Transaction failed: " . $e->getMessage();
            $errorMessage = $e->getMessage();
            include('../errors/error.php');
            exit;
        }
        
        if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
            Utility::adminReturnToDashboard();
        } else {
            Utility::returnToDashboard();
        } 
        break;

    default:
          // Borrowed this code from Andy
          // very helpful for debugging.
          // Show this is an unhandled $controllerChoice
          // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> action:  $action</h2>";
          echo "<h3> File:  user_manager/index.php </h3>";
          require_once '../view/footer.php';
}

?>