<?php

class Report {
    private $id, $reportTypeId, $userId, $body, $dateCreated;

public function __construct() {}

    // Getters and Setters

    public function getId() {
        return $this->id;
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