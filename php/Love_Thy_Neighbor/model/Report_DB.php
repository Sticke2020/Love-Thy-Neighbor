<?php
require_once("Report.php");
require_once("ReportType.php");
require_once("BusinessUser.php");


class ReportDB {

public static function getReports() {
    $db = DataBase::getDB();

    $query = 'SELECT report.* , username 
                FROM report
                LEFT JOIN user on user.id = report.user_id
                ORDER BY id DESC';

    $statement = $db->prepare($query);
    $statement->execute();

    $reports = array();
    foreach ($statement as $row) {
        $report = new Report();
        $report->setId($row['id']);
        $report->setReportTypeId($row['report_type_id']);
        $report->setUserId($row['user_id']);
        $report->setUserName($row['username']);
        $report->setBody($row['body']);
        $report->setDateCreated($row['date_created']);

        $reports[] = $report;
    }
    return $reports;
}

public static function createReport($report) {
    $reportTypeId = $report->getReportTypeId();
    $reportBody = $report->getBody();
    $userId = $report->getUserId();

    $db = DataBase::getDB();
    $query = 'INSERT INTO report
                (report_type_id, body, user_id)
                VALUES
                (:reportTypeId, :reportBody, :userId)';

    $statement = $db->prepare($query);
    $statement->bindValue(':reportTypeId', $reportTypeId);
    $statement->bindValue(':reportBody', $reportBody);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

public static function getReportTypes() {
    $db = DataBase::getDB();

    $query = 'Select * From report_type';

    $statement = $db->prepare($query);
    $statement->execute();

     $reportTypes = array();
    foreach ($statement as $row) {
        $reportType = new ReportType();
        $reportType->setId($row['id']);
        $reportType->setDescription($row['description']);
        
        $reportTypes[] = $reportType;
    }
    return $reportTypes;
}

public static function searchReportsByUserName($userName) {
    $db = DataBase::getDB();
	
    $userName = '%'.$userName.'%';
    $query = 'SELECT report.*, username
                FROM report 
                LEFT JOIN user on user.id = report.user_id
                WHERE username like :userName 
                ORDER BY id DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $reports = $statement->fetchAll();
    $statement->closeCursor();

    $reportsArray = array();
    foreach ($reports as $row) {
        $report = new Report();
        $report->setId($row['id']);
        $report->setReportTypeId($row['report_type_id']);
        $report->setUserId($row['user_id']);
        $report->setUserName($row['username']);
        $report->setBody($row['body']);
        $report->setDateCreated($row['date_created']);

        $reportsArray[] = $report;
    }
    return $reportsArray;
}

public static function deleteReports($userId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM report
            WHERE user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

}