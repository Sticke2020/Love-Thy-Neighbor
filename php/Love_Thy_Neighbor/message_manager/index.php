<?php

require_once('../model/database.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ( $controllerChoice == NULL) {
     $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ( $controllerChoice == NULL) {
         $controllerChoice = 'Not-Set (Null)';
    }
}



// Borrowed this code from Andy
// Final else very helpful for debugging.
else {
      // Show this is an unhandled $controllerChoice
       // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> controllerChoice:  $controllerChoice</h2>";
          echo "<h3> File:  user_manager/index.php </h3>";
          require_once '../view/footer.php';
}
?>