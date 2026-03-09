<?php

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
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
          include('../admin_manager/admin_dashboard.php');
          break;

     case 'search_users':
          $users = UserDB::getUsers();
          include('../admin_manager/admin_users.php');
          break;

     case 'search_users_by_username':
          $userName = filter_input(INPUT_POST, 'search_username');
          $users = UserDB::searchUsersByUserName($userName);
          include('../admin_manager/admin_users.php');
          break;

     case 'view_user':
          break;

     case 'requests':
          $requests = RequestDB::getRequests();
          include('../admin_manager/admin_requests.php');
          break;

     case 'requests_by_user_id':

          break;

     case 'edit_user':

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