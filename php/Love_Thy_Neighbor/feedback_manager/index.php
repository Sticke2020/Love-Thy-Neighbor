<?php

require_once('../model/Database.php');
require_once('../model/Feedback.php');
require_once('../model/Feedback_DB.php');
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
     case 'leave_feedback':
          $senderId = filter_input(INPUT_POST, 'sender_id');
          $receiverId = filter_input(INPUT_POST, 'receiver_id');
          include('feedback_create.php');
          break;

     case 'create_feedback':
          $senderId = filter_input(INPUT_POST, 'sender_id');
          $receiverId = filter_input(INPUT_POST, 'receiver_id');
          $comment = filter_input(INPUT_POST, 'comment');

          $feedback = new Feedback();
          $feedback->setSenderId($senderId);
          $feedback->setReceiverId($receiverId);
          $feedback->setComment($comment);

          if ($feedback->getSenderId() == null  || $feedback->getReceiverId() == null || $feedback->getComment() == null) {
               $errorMessage = "Invalid data, please try again.";
               include('../errors/error.php');
          }
          else if (strlen($feedback->getComment()) > 16000) {
               $errorMessage = "Feedback must be less that 16,000 characters long";
               include('../errors/error.php');
          }
          else {
               FeedbackDB::createFeedback($feedback);

               if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
                    Utility::adminReturnToDashboard();
               } else {
                    Utility::returnToDashboard();
               }
          }
          break;

          // Only admin can delete feedback right no
     case 'delete_feedback':
          $feedbackId = filter_input(INPUT_POST, 'feedback_id');
          FeedbackDB::deleteFeedbackById($feedbackId);
          Utility::adminReturnToDashboard();
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