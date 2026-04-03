<?php

$phoneNumbersOnly;
$areaCode;
$prefix;
$suffix;

require_once('../model/Database.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Log.php');
require_once('../model/Log_DB.php');
require_once('../model/Report.php');
require_once('../model/Report_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');
require_once('../model/Feedback.php');
require_once('../model/Feedback_DB.php');
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
          Utility::returnToDashboard();
          break;

     case 'users':
          $users = UserDB::getUsers();
          include('users.php');
          break;

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

          include('user_view_profile.php');
          break;

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

     case 'login_user':
          $errorMessage = "";
          include('user_login.php');
          break;

     case 'logout_user':
          $_SESSION = array();
          session_destroy();
          $lifetime = 60 * 60 * 24 * -14;
          setcookie('userSession', '', $lifetime, '/');
          $errorMessage = '';
          include('user_login.php');
          break;

     case 'validate_login':
          session_destroy();
          $_SESSION = array();
          session_start();

          $email = filter_input(INPUT_POST, 'email');
          $password = filter_input(INPUT_POST, 'password');

          if ($email == null || $password == null) {
               $errorMessage = "Please enter a valid email and password";
               include('user_login.php');
          } 
          else {
               $user = UserDB::getUserByEmailAndPassword($email,$password);
               if($user->getId() == false || $user->getId() == null) {
                    $errorMessage = "Incorrect email or password";
                    include('user_login.php');
               }
               else if ($user != false && $user != null) {
                    $ID = $user->getId();
                    if($ID > 0) {
                         $user = UserDB::getUserById($ID);
                         $errorMessage = "";
                         $business = null;
                         $businessUser = null;
                         session_regenerate_id(true);
                         $_SESSION['userId'] = $ID;

                         if ($user->getUserTypeId() == 1) {
                              $_SESSION['user'] = $user;
                              $profilePic = ImageDB::getImageById($user->getProfileImageId());
                              $unreadMessages = MessageDB::hasUnreadMessages($user->getId());
                              $reports = ReportDB::getReports();

                              include('../admin_manager/admin_dashboard.php');
                         }
                         else if ($user->getUserTypeId() != 1) {
                              $requests = RequestDB::getRequestsByUserId($ID);
                              $profilePic = ImageDB::getImageById($user->getProfileImageId());

                              // Check if user is also a business user
                              $isBusinessUser = BusinessDB::isBusinessUser($ID);

                              if ($isBusinessUser) {
                                   $businessUser = BusinessDB::getBusinessUserByUserId($ID);
                                   $business = BusinessDB::getBusinessById($businessUser->getBusinessId());
                                   $_SESSION['businessUser'] = $businessUser;
                              }
                              $feedback = FeedbackDB::getFeedbackByUserId($user->getId());
                              $unreadMessages = MessageDB::hasUnreadMessages($ID);

                              $log = new Log($ID, 5);
                              LogDB::createLog($log);
                              include('user_dashboard.php');
                         }
                    } 
                    else{
                         $errorMessage = "Incorrect email or password";
                         include('user_login.php');
                    }
               }
          }
          break;

     case 'add_user':
          $password = filter_input(INPUT_POST, 'password');
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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
          $user->setPassword($hashedPassword);
          $user->setAccountType(filter_input(INPUT_POST, 'account_type'));

          if ($user->getFirstName() == null || $user->getLastName() == null || $user->getCity() == null || $user->getState() == null ||
               $user->getZip() == null || $user->getPhone() == null || $user->getEmail() == null || $user->getPassword() == null ||
               $user->getUserName() == null) {

               $error = "Invalid user data. Check all fields and try again.";
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
          else if (UserDB::userNameExists($user->getUserName())) {
               $error = "UserName is NOT available, you must choose a different UserName";
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

     case 'add_user_employee':
          $password = filter_input(INPUT_POST, 'password');
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          $user = new User();
          $businessUser = new BusinessUser();
          $business = new Business();

          $user->setUserTypeId(3);
          $user->setFirstName(filter_input(INPUT_POST, 'first_name'));
          $user->setLastName(filter_input(INPUT_POST, 'last_name'));
          $user->setCity(filter_input(INPUT_POST, 'city'));
          $user->setState(filter_input(INPUT_POST, 'state'));
          $user->setZip(filter_input(INPUT_POST, 'zip'));
          $user->setPhone(filter_input(INPUT_POST, 'phone'));
          $user->setEmail(filter_input(INPUT_POST, 'email'));
          $user->setUserName(filter_input(INPUT_POST, 'user_name'));
          $user->setPassword($hashedPassword);
          $user->setAccountType(filter_input(INPUT_POST, 'account_type'));

          $businessId = (filter_input(INPUT_POST, 'business_id'));
          $verificationCode = (filter_input(INPUT_POST, 'business_code'));
          $business = BusinessDB::getBusinessById($businessId);

          if ($user->getFirstName() == null || $user->getLastName() == null || $user->getCity() == null || $user->getState() == null ||
               $user->getZip() == null || $user->getPhone() == null || $user->getEmail() == null || $user->getPassword() == null ||
               $user->getUserName() == null) {

               $error = "Invalid user data. Check all fields and try again.";
               include('../errors/error.php');
          }

          if (!empty($user->getPhone()) && (int)strlen($user->getPhone()) >= 10) {
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
               }
          }

          if (!str_contains($user->getEmail(), '@') || !str_contains($user->getEmail(), '.')) {
               $error = "You must enter a valid email address";
               include('../errors/error.php');
          }
          else if (UserDB::emailAddressExists($user->getEmail())) {
               $error = "Email address in use, you must use a different email address";
               include('../errors/error.php');
          }
          else if (UserDB::userNameExists($user->getUserName())) {
               $error = "UserName is NOT available, you must choose a different UserName";
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
          else if ($businessId == null || $verificationCode == null) {
               $error = "You must enter a Business ID and Verification Code";
               include('../errors/error.php');
          }
          else if ($business->getVerificationCode() != $verificationCode) {
               $error = "The Business ID and Verification code are invalid.\n".
                         "Please make sure you entered the ID and Code correctly.\n".
                         "If you continue to see this error contact your employer";
               include('../errors/error.php');
          }
          else {
               UserDB::createUser($user);
               $userId = UserDB::getUserByEmail($user->getEmail());
               BusinessDB::createBusinessUser($userId->getId(), $businessId, 0);
               include('user_employee_registered.php');
          }
          break;

     case 'add_user_business':
          $password = filter_input(INPUT_POST, 'password');
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          $user = new User();
          $businessUser = new BusinessUser();
          $business = new Business();

          $user->setUserTypeId(3);
          $user->setFirstName(filter_input(INPUT_POST, 'first_name'));
          $user->setLastName(filter_input(INPUT_POST, 'last_name'));
          $user->setCity(filter_input(INPUT_POST, 'city'));
          $user->setState(filter_input(INPUT_POST, 'state'));
          $user->setZip(filter_input(INPUT_POST, 'zip'));
          $user->setPhone(filter_input(INPUT_POST, 'phone'));
          $user->setEmail(filter_input(INPUT_POST, 'email'));
          $user->setUserName(filter_input(INPUT_POST, 'user_name'));
          $user->setPassword($hashedPassword);
          $user->setAccountType(filter_input(INPUT_POST, 'account_type'));

          $business->setName(filter_input(INPUT_POST, 'business_name'));
          $business->setPhone(filter_input(INPUT_POST, 'business_phone'));
          $business->setAddress(filter_input(INPUT_POST, 'business_address'));
          $business->setCity(filter_input(INPUT_POST, 'business_city'));
          $business->setState(filter_input(INPUT_POST, 'business_state'));
          $business->setZip(filter_input(INPUT_POST, 'business_zip'));
          $business->setDescription(filter_input(INPUT_POST, 'business_description'));
          $business->setVerificationCode(filter_input(INPUT_POST, 'business_code'));

          if ($user->getFirstName() == null || $user->getLastName() == null || $user->getCity() == null || $user->getState() == null ||
               $user->getZip() == null || $user->getPhone() == null || $user->getEmail() == null || $user->getPassword() == null ||
               $user->getUserName() == null) {

               $error = "Invalid user data. Check all fields and try again.";
               include('../errors/error.php');
          }

          if ($business->getName() == null || $business->getPhone() == null || $business->getAddress() == null ||
               $business->getCity() == null || $business->getState() == null || $business->getZip() == null ||
               $business->getDescription() == null || $business->getVerificationCode() == null) {

               $error = "Invalid Business data. Check all fields and try again.";
               include('../errors/error.php');
          }

          if (!empty($user->getPhone()) && (int)strlen($user->getPhone()) >= 10) {
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
               }
          }

          if (!empty($business->getPhone()) && (int)strlen($business->getPhone()) >= 10) {
               $phone = $business->getPhone();
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

                    $business->setPhone($areaCode . "-" . $prefix . "-" . $suffix);
               }
          }

          if (!str_contains($user->getEmail(), '@') || !str_contains($user->getEmail(), '.')) {
               $error = "You must enter a valid email address";
               include('../errors/error.php');
          }
          else if (UserDB::emailAddressExists($user->getEmail())) {
               $error = "Email address in use, you must use a different email address";
               include('../errors/error.php');
          }
          else if (UserDB::userNameExists($user->getUserName())) {
               $error = "UserName is NOT available, you must choose a different UserName";
               include('../errors/error.php');
          }
          else if (strlen(trim($user->getZip())) > 10) {
               $error = "Postal Code must be 10 digits or less.";
               include('../errors/error.php');
          }
          else if (strlen(trim($business->getZip())) > 10) {
               $error = "Postal Code must be 10 digits or less.";
               include('../errors/error.php');
          }
          else if (empty($user->getPhone()) || (int)strlen($user->getPhone()) < 10) {
               $error = "Phone number must be 10 digits\n". 
                              "Invalid phone number";
               include('../errors/error.php');
          }
          else if (empty($business->getPhone()) || (int)strlen($business->getPhone()) < 10) {
               $error = "Phone number must be 10 digits\n". 
                              "Invalid phone number";
               include('../errors/error.php');
          }
          else {
               UserDB::createUser($user);
               BusinessDB::createBusiness($business);

               $newBusiness = BusinessDB::getBusinessByName($business->getName());
               $userId = UserDB::getUserByEmail($user->getEmail());

               BusinessDB::createBusinessUser($userId->getId(), $newBusiness->getId(), 1);
               include('user_business_registered.php');
          }
          break;

     case 'edit_user':
          if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
               $user = UserDB::getUserById(filter_input(INPUT_POST, 'user_id'));
               $businessUser = BusinessDB::getBusinessUserByUserId($user->getId());

               if (BusinessDB::isBusinessUser($user->getId())) {
                    $business = BusinessDB::getBusinessById($businessUser->getBusinessId());

                    if ($businessUser->getIsAdmin() == 1) {
                         include("user_edit_business.php");
                         break;
                    }
                    else {
                         include("user_edit_info.php");
                         break;
                    }
               }
               else {
                    include("user_edit_info.php");
                    break;
               }
          }
          else {
               $user = UserDB::getUserById($_SESSION['userId']);
               include("user_edit_info.php");
               break;
          }

     case 'edit_business':
          $user = UserDB::getUserById($_SESSION['userId']);
          $business = BusinessDB::getBusinessById($_SESSION['businessUser']->getBusinessId());
          include("user_edit_business.php");
          break;

     case 'update_user':
          $user = new User();

          $user->setID(filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT));
          $user->setUserTypeId(filter_input(INPUT_POST, 'user_type_id'));
          $user->setFirstName(filter_input(INPUT_POST, 'first_name'));
          $user->setLastName(filter_input(INPUT_POST, 'last_name'));
          $user->setCity(filter_input(INPUT_POST, 'city'));
          $user->setState(filter_input(INPUT_POST, 'state'));
          $user->setZip(filter_input(INPUT_POST, 'zip'));
          $user->setEmail(filter_input(INPUT_POST, 'email'));
          $user->setPhone(filter_input(INPUT_POST, 'phone'));
          $user->setUserName(filter_input(INPUT_POST, 'user_name'));

          if ($user->getID() == null || $user->getUserTypeId() == null || $user->getFirstName() == null ||
               $user->getLastName() == null || $user->getCity() == null || $user->getState() == null || 
               $user->getZip() == null || $user->getEmail() == null || $user->getPhone() == null ||
               $user->getUserName() == null) {
          $error = "Invalid customer data. Check all fields and try again.";
          include('../errors/error.php');
          }
          else if (strlen(trim($user->getState())) !== 2) {
               $error = "State must be a 2 letters like AZ or CA";
               include('../errors/error.php');
          }
          else if (!str_contains($user->getEmail(), '@') || !str_contains($user->getEmail(), '.')) {
               $error = "You must enter a valid email address";
               include('../errors/error.php');
          }
          else if (UserDB::emailAddressExists($user->getEmail(), $user->getId())) {
               $error = "Email address in use, you must use a different email address";
               include('../errors/error.php');
          }
          else if (UserDB::userNameExists($user->getUserName(), $user->getId())) {
               $error = "UserName is NOT available, you must choose a different UserName";
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
                    $errormessage = "";
                    UserDB::updateUser($user);
               
                    include('../view/updates.php');
               }
          }
          else {
               UserDB::updateUser($user);
               include('../view/updates.php');
          }
          break;

     case 'change_password':
          $password = filter_input(INPUT_POST, 'current_password');
          $newPassword = filter_input(INPUT_POST, 'new_password');
          $newPasswordConfirmed = filter_input(INPUT_POST, 'new_password_confirmed');

          if (UserDB::confirmUserPassword($_SESSION['userId'], $password)) {
               if ($newPassword === $newPasswordConfirmed && $newPassword != null) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    UserDB::updatePassword($_SESSION['userId'], $hashedPassword);
                    include('../view/updates.php');
               }
               else {
                    $error = "Your new password entries do not match";
                    include('../errors/error.php');
               }
          }
          else {
               $error = "Your current password is incorrect";
                    include('../errors/error.php');
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