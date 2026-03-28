<?php

require_once('../model/Database.php');
require_once('../model/Report.php');
require_once('../model/Report_DB.php');

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

            ReportDB::createReport($report);

            include('../report_manager/report_created.php');
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