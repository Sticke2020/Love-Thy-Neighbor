<?php

require_once('../model/Database.php');

// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ( $controllerChoice == NULL) {
     $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ( $controllerChoice == NULL) {
         $controllerChoice = 'Not-Set (Null)';
    }
}

switch ($controllerChoice) {

     case 'register_user':
          include('user_register.php');
          break;

     default:
          // Borrowed this code from Andy
          // very helpful for debugging.
          // Show this is an unhandled $controllerChoice
          // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> controllerChoice:  $controllerChoice</h2>";
          echo "<h3> File:  user_manager/index.php </h3>";
          require_once '../view/footer.php';
}
?>