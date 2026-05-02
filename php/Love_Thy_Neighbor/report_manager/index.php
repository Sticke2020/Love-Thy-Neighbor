<?php

require_once('../model/Database.php');
require_once('../model/Report.php');
require_once('../model/Report_DB.php');
require_once('../model/User.php');
require_once('../model/User_DB.php');
require_once('../model/Image.php');
require_once('../model/Image_DB.php');
require_once('../model/Message.php');
require_once('../model/Message_DB.php');
require_once('../model/Log.php');
require_once('../model/Log_DB.php');
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

    case 'file_report':
            $reportTypes = ReportDB::getReportTypes();

            include('../report_manager/report_create.php');
            break;

    case 'create_report':
            $reportTypeId = filter_input(INPUT_POST, 'report_type_id');
            $reportBody = filter_input(INPUT_POST, 'report_body');
            $userId = filter_input(INPUT_POST, 'user_id');

            $report = new Report();
            $report->setReportTypeId($reportTypeId);
            $report->setBody($reportBody);
            $report->setUserId($userId);

            if (!$reportTypeId || !$reportBody || !$userId) {
                $error = "Something went wrong, Please try again.";
                include('../errors/error.php');
                exit;
            }
            else if (strlen($reportBody) > 2000) {
                $error = "Report must be 2,000 characters or less.";
                include('../errors/error.php');
                exit;
            }

            $log = new Log($userId, 10); // 10 = File Report
            LogDB::createLog($log);
    
            ReportDB::createReport($report);

            include('../report_manager/report_created.php');
            break;

    case 'search_reports_by_username':
            $userName = filter_input(INPUT_POST, 'search_username');
            $reports = ReportDB::searchReportsByUserName($userName);
            $user = UserDB::getUserById($_SESSION['userId']);
            $profilePic = ImageDB::getImageById($user->getProfileImageId());
            $unreadMessages = MessageDB::hasUnreadMessages($user->getId());

            include('../admin_manager/admin_dashboard.php');
            break;

    case 'search_reports_by_type_id':
            $typeId = filter_input(INPUT_POST, 'search_report_id');
            $reports = ReportDB::searchReportsByTypeId($typeId);
            $user = UserDB::getUserById($_SESSION['userId']);
            $profilePic = ImageDB::getImageById($user->getProfileImageId());
            $unreadMessages = MessageDB::hasUnreadMessages($user->getId());

            include('../admin_manager/admin_dashboard.php');
            break;

    case 'delete_report':
            $reportId = filter_input(INPUT_POST, 'report_id');
            ReportDB::deleteReportByReportId($reportId);

            Utility::adminReturnToDashboard();
            break;

    default:
          // Borrowed this code from Andy
          // very helpful for debugging.
          // Show this is an unhandled $action
          // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> action:  $action</h2>";
          echo "<h3> File:  user_manager/index.php </h3>";
          require_once '../view/footer.php';
}

?>