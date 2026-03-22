<?php

require_once('../model/Database.php');
require_once('../model/Message.php');
require_once('../model/Message_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/User_DB.php');
require_once('../model/User.php');



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

     case 'messages': 
          $userId = filter_input(INPUT_POST, 'user_id');
          $messages = MessageDB::getMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          include('../message_manager/messages.php');
          break;

     case 'message_content':
          $userId = filter_input(INPUT_POST, 'user_id');
          $messageId = filter_input(INPUT_POST,'message_id');
          $messages = MessageDB::getMessagesByUserId($userId);
          $messageContent = MessageDB::getMessageByMessageId($messageId);
          $userNames = UserDB::getUserNames();

          include('../message_manager/messages.php');
          break;

     case 'send_message':
          $recipientUserName = filter_input(INPUT_POST, 'recipient_username');
          $messageBody = filter_input(INPUT_POST, 'message_body');
          $senderId = filter_input(INPUT_POST, 'user_id');
          

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
               MessageDB::createMessage($message);
          }

          $userId = $senderId;
          $messages = MessageDB::getMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          include('../message_manager/messages.php');
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
