<?php

require_once('../model/database.php');
require_once('../model/Image_DB.php');
require_once('../model/Image.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Request_DB.php');
require_once('../model/Request.php');

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

    case 'add_request_image':
        
        break;

    case 'upload_profile_image':
        $image = filter_input(INPUT_POST, 'image');
        $userId = filter_input(INPUT_POST, 'user_id');
        try {
               $db = DataBase::getDB();
               $db->beginTransaction();

               $uploadDirectory = '/var/www/uploads/';

               ImageDB::uploadProfileImage($uploadDirectory, $userId);

               $db->commit();
          }
          catch (PDOException $e) {
               $db->rollBack();
               echo "Transaction failed: " . $e->getMessage();
          }
        $user = UserDB::getUserById($userId);
        $requests = RequestDB::getRequestsByUserId($user->getId());
        $profilePic = ImageDB::getImageById($user->getProfileImageId());
        include('../user_manager/user_dashboard.php');
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