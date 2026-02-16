<?php

require_once('../model/database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');

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

     case 'user_requests':
          $requests = RequestDB::getRequestsByUserId($_SESSION['userId']);
          break;

     case 'requests':
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
               $uploadDirectory = '/var/www/uploads/';

               ImageDB::uploadRequestImages($requestId, $uploadDirectory, $userId);

               $db->commit();
          }
          catch (PDOException $e) {
               $db->rollBack();
               echo "Transaction failed: " . $e->getMessage();
          }
          include('requests.php');
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