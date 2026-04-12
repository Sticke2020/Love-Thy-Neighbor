<?php

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');
require_once('../model/Utility.php');
require_once('../model/Message.php');
require_once('../model/Message_DB.php');


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
/*******test to see if this is ever used *****************************************************************

     case 'user_requests':
          $requests = RequestDB::getRequestsByUserId($_SESSION['userId']);
          break;

**********************************************************************************************************/  
     case 'requests':
          $requests = RequestDB::getRequests();
          include('requests.php');
          break;

     case 'requests_by_user_id':
          
          break;

     case 'fulfilled_requests':
          $requestsAll = RequestDB::getRequests();
          $requests = array();

          foreach ($requestsAll as $request) {
               if ($request->getRequestStatusTypeId() === 2) {
                    $requests[] = $request;
               }
          }

          include('requests.php');
          break;

     case 'unfulfilled_requests':
          $requestsAll = RequestDB::getRequests();
          $requests = array();

          foreach ($requestsAll as $request) {
               if ($request->getRequestStatusTypeId() === 1) {
                    $requests[] = $request;
               }
          }

          include('requests.php');
          break;

     case 'make_request':
          $userId = $_SESSION['userId'];
          include('request_create.php');
          break;

     case 'create_request':
          $request = new Request();

          $request->setTitle(filter_input(INPUT_POST, 'title'));
          $request->setBody(filter_input(INPUT_POST, 'body'));
          $request->setUserId(filter_input(INPUT_POST, 'user_id'));
          $request->setRequestStatusTypeId(1);

          $userId = filter_input(INPUT_POST, 'user_id');

          try {
               $db = DataBase::getDB();
               $db->beginTransaction();

               $requestId = RequestDB::createRequest($request);

               ImageDB::uploadRequestImages($requestId, $userId);

               $db->commit();
          }
          catch (PDOException $e) {
               $db->rollBack();
               echo "Transaction failed: " . $e->getMessage();
          }

          $requests = RequestDB::getRequests();
          include('requests.php');
          break;

     case 'edit_request':
          $requestId = filter_input(INPUT_POST, 'request_id');
          $request = RequestDB::getRequestById($requestId);

          include('request_edit.php');
          break;

     case 'update_request':
          $userId = $_SESSION['userId'];
          $requestId = filter_input(INPUT_POST, 'request_id');
          $title = filter_input(INPUT_POST, 'title');
          $body = filter_input(INPUT_POST, 'body');

          try{
          $db = DataBase::getDB();
          $db->beginTransaction();

          RequestDB::updateRequest($requestId, $title, $body);

          if (!empty($_POST['delete_images'])) {
               foreach ($_POST['delete_images'] as $imageId) {
                    ImageDB::deleteImageFromImageServer($imageId, null);
                    ImageDB::deleteRequestImageTableEntry($imageId);
                    ImageDB::deleteImageById($imageId);
               }
          }

          ImageDB::uploadRequestImages($requestId, $userId);

          $db->commit();
          }
          catch (Exception $e) {
               $db->rollBack();
          }

          if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
               Utility::adminReturnToDashboard();
          } else {
               Utility::returnToDashboard();
          }
          break;

     case 'delete_request':
          $requestId = filter_input(INPUT_POST, 'request_id');

          try {
               $db = DataBase::getDB();
               $db->beginTransaction();

               $images = ImageDB::getImagesByRequestId($requestId);

               foreach ($images as $image) {
                    $imageId = $image->getId();

                    ImageDB::deleteImageFromImageServer($imageId, null);
                    ImageDB::deleteRequestImageTableEntry($imageId);
                    ImageDB::deleteImageById($imageId);
               }

               RequestDB::deleteRequest($requestId);

               $db->commit();

          } catch (Exception $e) {
               $db->rollBack();
               error_log($e->getMessage());
          }
          
          if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
               Utility::adminReturnToDashboard();
          } else {
               Utility::returnToDashboard();
          }
          break;

     case 'fulfill_request':
          $requestTitle = filter_input(INPUT_POST, 'request_title');
          $receiverId = filter_input(INPUT_POST, 'receiver_id');
          $userId = $_SESSION['userId'];
          $user = UserDB::getUserById($userId);
          $userName = $user->getUserName();
          $body = "$userName wants to fulfull your request ($requestTitle). Send them a message if you are interested in having them
                              fulfill your request. Remember to mark your request as fulfilled after it has been fulfilled.";
          $message = new Message();
          $message->setBody($body);
          $message->setSenderId($userId);
          $message->setReceiverId($receiverId);

          MessageDB::createMessage($message);
          include('fulfill_request.php');
          break;

     case 'mark_request_fulfilled':
          $requestId = filter_input(INPUT_POST, 'request_id');
          RequestDB::markRequestFulfilled($requestId);

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