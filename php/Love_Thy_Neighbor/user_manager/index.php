<?php

$phoneNumbersOnly;
$areaCode;
$prefix;
$suffix;

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');

// Get the data from either the GET or POST collection.
$action = filter_input(INPUT_POST, 'action');
if ( $action == NULL) {
     $action = filter_input(INPUT_GET, 'action');
    if ( $action == NULL) {
         $action = 'Not-Set (Null)';
    }
}

switch ($action) {

     case 'sign_up':
          include('user_choose_account_type.php');
          break;

     case 'register_account':
          $accountType = filter_input(INPUT_POST, 'account_type');

          if ($accountType == 'PERSONAL') {
               include('user_register.php');
          }
          else if ($accountType == 'EMPLOYEE') {
               include('user_employee_register.php');
          }
          else if ($accountType == 'BUSINESS') {
               include('user_business_register.php');
          }
          break;

     case 'add_user':
          $user = new User();

          $user->setUserTypeId(3);
          $user->setFirstName(filter_input(INPUT_POST, 'first_name'));
          $user->setLastName(filter_input(INPUT_POST, 'last_name'));
          $user->setCity(filter_input(INPUT_POST, 'city'));
          $user->setState(filter_input(INPUT_POST, 'state'));
          $user->setZip(filter_input(INPUT_POST, 'zip'));
          $user->setPhone(filter_input(INPUT_POST, 'phone'));
          $user->setEmail(filter_input(INPUT_POST, 'email'));
          $user->setUserName(filter_input(INPUT_POST, 'user_name'));
          $user->setPassword(filter_input(INPUT_POST, 'password'));
          $user->setAccountType(filter_input(INPUT_POST, 'account_type'));

          if ($user->getFirstName() == null || $user->getLastName() == null || $user->getCity() == null || $user->getState() == null ||
               $user->getZip() == null || $user->getPhone() == null || $user->getEmail() == null || $user->getPassword() == null ||
               $user->getUserName() == null) {

               $errorMessage = "Invalid user data. Check all fields and try again.";
               include('../errors/error.php');
          }
          else if (!str_contains($user->getEmail(), '@') || !str_contains($user->getEmail(), '.')) {
               $error = "You must enter a valid email address";
               include('../errors/error.php');
          }
          else if (UserDB::emailAddressExists($user->getEmail())) {
               $error = "Email address in use, you must use a different email address";
               include('../errors/error.php');
          }
          else if (strlen(trim($user->getZip())) > 10) {
               $error = "Postal Code must be 10 digits or less.";
               include('../errors/error.php');
          }
          else if (empty($user->getPhone()) || (int)strlen($user->getPhone()) < 10) {
               $error = "Phone number must be 10 digits\n". 
                              "Invalid phone number";
               include('../errors/error.php');
          }
          else if (!empty($user->getPhone()) && (int)strlen($user->getPhone()) >= 10) {
               $phone = $user->getPhone();
               $phoneNumbersOnly = preg_replace('/\D/', '', $phone);

               if ((int)strlen($phoneNumbersOnly) != 10) {
                    $error = "Phone number must be 10 digits\n". 
                         "Invalid phone number";
                    include('../errors/error.php');
               }
               else if ((int)strlen($phoneNumbersOnly) == 10) {
                    $areaCode = substr($phoneNumbersOnly, 0 , 3);
                    $prefix = substr($phoneNumbersOnly, 3 , 3);
                    $suffix = substr($phoneNumbersOnly, 6 , 4);

                    $user->setPhone($areaCode . "-" . $prefix . "-" . $suffix);
                    UserDB::createUser($user);
               
                    include('user_registered.php');
               }
          }
          else {
               UserDB::createUser($user);
               include('user_registered.php');
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