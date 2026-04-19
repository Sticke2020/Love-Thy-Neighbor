<?php


require_once('../model/User_DB.php');
require_once('../model/User.php');
require_once('../model/Request.php');
require_once('../model/Request_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
require_once('../model/Business.php');
require_once('../model/Business_DB.php');
require_once('../model/BusinessUser.php');
require_once('../model/Feedback.php');
require_once('../model/Feedback_DB.php');
require_once('../model/Message.php');
require_once('../model/Message_DB.php');
require_once('../model/Report.php');
require_once('../model/Report_DB.php');

class Utility {

/* This gathers the variables and objects needed by the user dashboard */
public static  function returnToDashboard() {
    $user = UserDB::getUserById($_SESSION['userId']);
    $requests = RequestDB::getRequestsByUserId($user->getId());
    $profilePic = ImageDB::getImageById($user->getProfileImageId());
    $feedback = FeedbackDB::getFeedbackByUserId($user->getId());
    $unreadMessages = MessageDB::hasUnreadMessages($user->getId());
    $business = null;

    if (isset($_SESSION['businessUser'])) {
        $business = BusinessDB::getBusinessById($_SESSION['businessUser']->getBusinessId());
    }

    include('../user_manager/user_dashboard.php');
}

/* This gathers the variables and objects needed by the admin dashboard */
public static  function adminReturnToDashboard() {
    $user = UserDB::getUserById($_SESSION['userId']);
    $profilePic = ImageDB::getImageById($user->getProfileImageId());
    $unreadMessages = MessageDB::hasUnreadMessages($user->getId());
    $reports = ReportDB::getReports();

    include('../admin_manager/admin_dashboard.php');
}

// Deletes user account along with all data in DB that is linked to that user
// Currently a hard delete on everything but eventually will change to soft delete 
// then will auto hard delete after X amount of time passes
// Everything is deleted in an order that wont violate DB relationships
public static function deleteAccount($userId) {
    $userId = $userId;
    $user = UserDB::getUserById($userId);
    $requests = RequestDB::getRequestsByUserId($userId);
    $profilePic = ImageDB::getImageById($user->getProfileImageId());
    $feedback = FeedbackDB::getFeedbackByUserId($userId);
    $messageIds = MessageDB::getMessageIdsByUserId($userId);
    $business = null;
    $businessUser = null;
    $employees = null;

    if ($feedback) {
        FeedbackDB::deleteFeedbackByUserId($userId);
    }

    if ($requests) {
        foreach ($requests as $request) {
            $requestId = $request->getId();
            $images = ImageDB::getImagesByRequestId($requestId);

            foreach ($images as $image) {
                    $imageId = $image->getId();

                    try {
                        ImageDB::deleteImageFromImageServer($imageId, null);
                    }
                    catch (Exception $e) {
                        error_log($e->getMessage());
                    }
                    ImageDB::deleteRequestImageTableEntry($imageId);
                    ImageDB::deleteImageById($imageId);
            }
            RequestDB::deleteRequest($requestId);
        }
    }

    if ($profilePic) {
        $imageId = $profilePic->getId();

        try {
            ImageDB::deleteImageFromImageServer($imageId, $profilePic);
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }
        userDB::setUserProfilePic($userId, null);
        ImageDB::deleteImageById($imageId);
    }

    if (isset($_SESSION['businessUser'])) {
        $businessUser = BusinessDB::getBusinessUserByUserId($userId);
        
        if ($businessUser->getIsAdmin()) {
            $employees = BusinessDB::getBusinessEmployeesByBusinessId($businessUser->getBusinessId());

            foreach ($employees as $employee) {
                BusinessDB::removeEmployeeFromBusiness($employee->getUserId(), $employee->getBusinessId());
            }

            BusinessDB::deleteBusiness($businessUser->getBusinessId());
        }
        else {
            BusinessDB::removeEmployeeFromBusiness($userId, $businessUser->getBusinessId());
        }
    }

    if ($messageIds) {
        foreach ($messageIds as $message) {
            MessageDB::deleteMessagesByMessageId($message->getId());
        }
    }

    ReportDB::deleteReports($userId);
    LogDB::deleteLogs($userId);
    

    $_SESSION = array();
    session_destroy();
    $lifetime = 60 * 60 * 24 * -14;
    setcookie('userSession', '', $lifetime, '/');
    include('user_login.php');

    if ($user) {
        UserDB::deleteUser($userId);
    }
    
    exit;
}

}