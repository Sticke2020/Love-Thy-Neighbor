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
          $inbox = MessageDB::getInboxMessagesByUserId($userId);
          $outbox = MessageDB::getOutboxMessagesByUserId($userId);
          $userNames = UserDB::getUserNames();

          include('../message_manager/messages.php');
          break;

     case 'message_content': // For users to display messages they want to read
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

          include('../message_manager/messages.php');
          break;

     case 'message_user':
          $userId = filter_input(INPUT_POST, 'user_id');
          $user = UserDB::getUserById($userId);
          include('../message_manager/message_create.php');
          break;

     case 'send_message':
          $recipientUserName = filter_input(INPUT_POST, 'recipient_username');
          $messageBody = null;
          $userId = null;
          $senderId = null;
          $sentMessages = null;

          if (isset($recipientUserName)) {
               //$recipientUserName = filter_input(INPUT_POST, 'recipient_username');
               $messageBody = filter_input(INPUT_POST, 'message_body');
               $senderId = filter_input(INPUT_POST, 'user_id');
               $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
          
               if ($messageBody == null || $recipientUserName == null) {
                    $errorMessage = "Invalid data. Check all fields and try again.";
                    include('../errors/error.php');
                    exit;
               }
               else if (!UserDB::userNameExists($recipientUserName)) {
                    $errorMessage = "Username is invalid, Username must be spelled exactly correct, Please try again";
                    include('../errors/error.php');
                    exit;
               }
               else if (strlen($messageBody) > 2000) {
                    $errorMessage = "Message must be 2000 characters or less.";
                    include('../errors/error.php');
                    exit;
               }
               else {
                    $recipient = UserDB::getUserByUserName($recipientUserName);

                    $message = new Message();
                    $message->setBody($messageBody);
                    $message->setSenderId($senderId);
                    $message->setReceiverId($recipient->getId());
                    $message->setIsRead(0);

                    try {
                         MessageDB::createMessage($message);
                    }
                    catch (Exception $e) {
                         $error = "Something went wrong while sending your message. Please try again at another time.";
                         include('../errors/error.php');
                         exit;
                    }
                    $userId = $senderId;
                    $inbox = MessageDB::getInboxMessagesByUserId($senderId);
                    $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
                    $userNames = UserDB::getUserNames();

                    include('../message_manager/messages.php');
                    exit;
               }
          }
          else if (!isset($recipientUserName)) {
               $messageBody = filter_input(INPUT_POST, 'message_body');
               $senderId = $_SESSION['userId'];
               $receiverId = filter_input(INPUT_POST, 'user_id');

               if (!$messageBody || !$senderId || !$receiverId) {
                    $errorMessage = "Invalid data. Check all fields and try again.";
                    include('../errors/error.php');
                    exit;
               }
               else if (strlen($messageBody) > 2000) {
                    $errorMessage = "Message must be 2000 characters or less.";
                    include('../errors/error.php');
                    exit;
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
                         exit;
                    }

                    $userId = $senderId;
                    $inbox = MessageDB::getInboxMessagesByUserId($senderId);
                    $outbox = MessageDB::getOutboxMessagesByUserId($senderId);
                    $userNames = UserDB::getUserNames();

                    include('../message_manager/messages.php');
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
