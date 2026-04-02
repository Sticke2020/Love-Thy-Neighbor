<?php

class Report {
    private $id, $reportTypeId, $userId, $userName, $body, $dateCreated;

public function __construct() {}

    public function getReportTypes() {
        $types = [
            1 => "Harassment Or Bullying",
            2 => "Threats Or Abusive Language",
            3 => "Impersonation",
            4 => "Fake Profile",
            5 => "Spamming",
            6 => "Scamming",
            7 => "Illegal Content",
            8 => "Suspicious Behavior",
            9 => "Technical Issue",
            10 => "Technical Error",
            11 => "Need Assistance",
            ];
        return $types[$this->getReportTypeId()] ?? "unknown";
    }

    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function setId($value) {
        return $this->id = $value;
    }

    public function getReportTypeId() {
        return $this->reportTypeId;
    }

    public function setReportTypeId($value) {
        return $this->reportTypeId = $value;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        return $this->userId = $value;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($value) {
        return $this->userName = $value;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($value) {
        return $this->body = $value;
    }

     public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }
}