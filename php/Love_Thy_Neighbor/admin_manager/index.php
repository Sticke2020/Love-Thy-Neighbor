<?php

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/Utility.php');

// Create a session if there is none
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
     case 'hash_passwords':
          UserDB::hashPasswordsInDB();
          break;

     case 'home':
          Utility::adminReturnToDashboard();
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

     case 'search_users_by_lastname':
          $lastName = filter_input(INPUT_POST, 'search_lastname');
          $users = UserDB::searchUsersByLastName($lastName);
          include('../admin_manager/admin_users.php');
          break;

     case 'search_users_by_id':
          $id = filter_input(INPUT_POST, 'search_id');
          $users = UserDB::searchUsersById($id);
          include('../admin_manager/admin_users.php');
          break;

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