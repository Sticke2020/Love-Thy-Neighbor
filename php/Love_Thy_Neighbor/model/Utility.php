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
require_once('../model/Utility.php');

class Utility {

    // This gathers the variables and objects needed by the user dashboard
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


}