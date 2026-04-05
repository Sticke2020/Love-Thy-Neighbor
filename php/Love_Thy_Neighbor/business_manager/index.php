<?php

$phoneNumbersOnly;
$areaCode;
$prefix;
$suffix;

require_once('../model/Database.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/BusinessUser.php');
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

    case 'update_business':
        $business = new Business();

        $business->setID(filter_input(INPUT_POST, 'business_id', FILTER_VALIDATE_INT));
        $business->setName(filter_input(INPUT_POST, 'business_name'));
        $business->setPhone(filter_input(INPUT_POST, 'business_phone'));
        $business->setAddress(filter_input(INPUT_POST, 'business_address'));
        $business->setCity(filter_input(INPUT_POST, 'business_city'));
        $business->setState(filter_input(INPUT_POST, 'business_state'));
        $business->setZip(filter_input(INPUT_POST, 'business_zip'));
        $business->setDescription(filter_input(INPUT_POST, 'business_description'));
        $business->setVerificationCode(filter_input(INPUT_POST, 'business_code'));
        
        if ($business->getID() == null || $business->getName() == null || $business->getPhone() == null ||
            $business->getAddress() == null || $business->getCity() == null ||
            $business->getState() == null || $business->getZip() == null || $business->getDescription() == null ||
            $business->getVerificationCode() == null) {
            $error = "Invalid customer data. Check all fields and try again.";
            include('../errors/error.php');
        }
        else if (strlen(trim($business->getState())) !== 2) {
            $error = "State must be a 2 letters like AZ or CA";
            include('../errors/error.php');
        }
        else if (empty($business->getPhone()) || (int)strlen($business->getPhone()) < 10) {
            $error = "Phone number must be 10 digits\n". 
                        "Invalid phone number";
            include('../errors/error.php');
        }
        else if (!empty($business->getPhone()) && (int)strlen($business->getPhone()) >= 10) {
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
                $errorMessage = "";
                BusinessDB::updateBusiness($business);
            
                include('../view/updates.php');
            }
        }
        else {
            BusinessDB::updateBusiness($business);
            include('../view/updates.php');
        }
        break;

        case 'remove_employee':
            $employeeId = filter_input(INPUT_POST, 'employee_id');
            $businessId = filter_input(INPUT_POST, 'business_id');
            BusinessDB::removeEmployeeFromBusiness($employeeId, $businessId);

            Utility::returnToDashboard();
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