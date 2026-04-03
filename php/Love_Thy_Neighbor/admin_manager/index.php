<?php

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');
require_once('../model/Report.php');
require_once('../model/Report_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
require_once('../model/Feedback.php');
require_once('../model/Feedback_DB.php');
require_once('../model/Utility.php');

if(session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 14;
    session_name('userSession');
    session_set_cookie_params($lifetime, '/');
    session_start();
}


// Get the data from either the GET or POST collection.
$action = filter_input(INPUT_POST, 'action');
if ( $action == NULL) {
     $action = filter_input(INPUT_GET, 'action');
    if ( $action == NULL) {
         $action = 'Not-Set (Null)';
    }
}

switch ($action) { 
/*  REMOVE THIS CASE BEFORE FINAL PRODUCTION ******************
     case 'hash_passwords':
          UserDB::hashPasswordsInDB();
          break;

*****************************************************************/
     case 'home':
          $user = UserDB::getUserById($_SESSION['userId']);
          $profilePic = ImageDB::getImageById($user->getProfileImageId());
          $unreadMessages = MessageDB::hasUnreadMessages($user->getId());
          $reports = ReportDB::getReports();
          include('../admin_manager/admin_dashboard.php');
          break;

/**********  USERS  *********************************************/

     case 'search_users':
          $users = UserDB::getUsers();
          include('../admin_manager/admin_users.php');
          break;

     case 'search_users_by_username':
          $userName = filter_input(INPUT_POST, 'search_username');
          $users = UserDB::searchUsersByUserName($userName);
          include('../admin_manager/admin_users.php');
          break;

     case 'search_users_by_lastname':
          $lastName = filter_input(INPUT_POST, 'search_lastname');
          $users = UserDB::searchUsersByLastName($lastName);
          include('../admin_manager/admin_users.php');
          break;
/*
     case 'view_user':
          $userId = filter_input(INPUT_POST, 'user_id');
          $user = UserDB::getUserById($userId);
          $requests = RequestDB::getRequestsByUserId($user->getId());
          $profilePic = ImageDB::getImageById($user->getProfileImageId());
          $feedback = FeedbackDB::getFeedbackByUserId($user->getId());
          $business = null;
          $businessUser = new BusinessUser();

          if (BusinessDB::isBusinessUser($userId)) {
               $businessUser = BusinessDB::getBusinessUserByUserId($userId);
               $business = BusinessDB::getBusinessById($businessUser->getBusinessId());
          }

          include('../admin_manager/admin_view_user_profile.php');
          break;

*/
     case 'edit_user':
          $user = UserDB::getUserById(filter_input(INPUT_POST, 'user_id'));
          $businessUser = BusinessDB::getBusinessUserByUserId($user->getId());
          $business = null;
          if (!$businessUser) {
               include("admin_edit_user_info.php");
               break;
          }
          else {
               $business = BusinessDB::getBusinessById($businessUser->getBusinessId());
               include("admin_edit_user_business.php");
               break;
          }
          break;



/************  REQUESTS  ******************************************

     case 'requests':
          $requests = RequestDB::getRequests();
          include('../admin_manager/admin_requests.php');
          break;

     case 'edit_request':
          $requestId = filter_input(INPUT_POST, 'request_id');
          $request = RequestDB::getRequestById($requestId);

          include('admin_request_edit.php');
          break;

     case 'update_request':
          $requestId = filter_input(INPUT_POST, 'request_id');
          $user = UserDB::getUserIdByRequestId($requestId);
          $userId = $user->getId();
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

          include('admin_dashboard.php');
          break;
*/
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
          
          include('admin_dashboard.php');
          break;

     case 'make_request':
          $userId = $_SESSION['userId'];
          include('admin_request_create.php');
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

     case 'requests_by_user_id':
          
          break;

/*******************  MESSAGES  *****************************************/
    /* case 'messages':
          $userId = filter_input(INPUT_POST, 'user_id');
          $inbox = MessageDB::getInboxMessagesByUserId($userId);
          $outbox = MessageDB::getOutboxMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          include('../admin_manager/admin_messages.php');
          break;

     case 'message_content':
          $userId = filter_input(INPUT_POST, 'user_id');
          $messageId = filter_input(INPUT_POST,'message_id');
          $folder = filter_input(INPUT_POST, 'folder');
          $message = MessageDB::getMessageByMessageId($messageId, $userId);
          $inbox = MessageDB::getInboxMessagesByUserId($userId);
          $messageContent = MessageDB::getMessageByMessageId($messageId, $userId);
          $outbox = MessageDB::getOutboxMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          if (!$message->getIsRead()) {
               MessageDB::messageIsRead($messageId);
          }

          include('../admin_manager/admin_messages.php');
          break;

     case 'send_message':
          $recipientUserName = filter_input(INPUT_POST, 'recipient_username');
          $messageBody = null;
          $userId = null;
          $senderId = null;
          $sentMessages = null;

          if (isset($recipientUserName)) {
               $recipientUserName = filter_input(INPUT_POST, 'recipient_username');
               $messageBody = filter_input(INPUT_POST, 'message_body');
               $senderId = filter_input(INPUT_POST, 'user_id');
               $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
          

               if ($messageBody == null || $recipientUserName == null) {
                    $errorMessage = "Invalid data. Check all fields and try again.";
                    include('../errors/error.php');
               }
               else if (!UserDB::userNameExists($recipientUserName)) {
                    $errorMessage = "Username is invalid, Username must be spelled exactly correct, Please try again";
                    include('../errors/error.php');
               }
               else {
                    $recipent = UserDB::getUserByUserName($recipientUserName);
                    $message = new Message();
                    $message->setBody($messageBody);
                    $message->setSenderId($senderId);
                    $message->setReceiverId($recipent->getId());
                    $message->setIsRead(0);

                    try {
                         MessageDB::createMessage($message);
                    }
                    catch (Exception $e) {
                         $error = "Something went wrong while sending your message. Please try again at another time.";
                         include('../errors/error.php');
                    }
                    $userId = $senderId;
                    $inbox = MessageDB::getInboxMessagesByUserId($senderId);
                    $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
                    $userNames = UserDB::getUserNames();

                    include('../admin_manager/admin_messages.php');
               }
          }
          else if (!isset($recipientUserName)) {
               $messageBody = filter_input(INPUT_POST, 'message_body');
               $senderId = $_SESSION['userId'];
               $receiverId = filter_input(INPUT_POST, 'user_id');

               if ($messageBody == null) {
                    $errorMessage = "Invalid data. Check all fields and try again.";
                    include('../errors/error.php');
               }
               else {
                    $message = new Message();
                    
                    $message->setBody($messageBody);
                    $message->setSenderId($senderId);
                    $message->setReceiverId($receiverId);

                    try {
                         MessageDB::createMessage($message);
                    }
                    catch (Exception $e) {
                         $error = "Something went wrong while sending your message. Please try again at another time.";
                         include('../errors/error.php');
                    }

                    $userId = $senderId;
                    $inbox = MessageDB::getInboxMessagesByUserId($senderId);
                    $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
                    $userNames = UserDB::getUserNames();

                    include('../admin_manager/admin_messages.php');
               }
          }
          break;

     case 'delete_message':
          $userId = filter_input(INPUT_POST, 'user_id');
          $messageId = filter_input(INPUT_POST,'message_id');

          MessageDB::softDeleteMessage($userId, $messageId);

          $message = MessageDB::getMessageByMessageId($messageId, $userId);
          $inbox = MessageDB::getInboxMessagesByUserId($userId);
          
          $outbox = MessageDB::getOutboxMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          include('../admin_manager/admin_messages.php');
          break;

/*******************  REPORTS  *****************************************/
     case 'search_reports_by_username':
          $userName = filter_input(INPUT_POST, 'search_username');
          $reports = ReportDB::searchReportsByUserName($userName);
          $user = UserDB::getUserById($_SESSION['userId']);
          $profilePic = ImageDB::getImageById($user->getProfileImageId());
          $unreadMessages = MessageDB::hasUnreadMessages($user->getId());

          include('../admin_manager/admin_dashboard.php');
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