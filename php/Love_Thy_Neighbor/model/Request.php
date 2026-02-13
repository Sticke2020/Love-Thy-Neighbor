<?php

class Request {
    private $id, $userId, $title, $body, $requestStatusTypeId, $dateCreated;

    public function __construct() {}

    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        return $this->userId = $value;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($value) {
        return $this->title = $value;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($value) {
        return $this->body = $value;
    }

    public function getRequestStatusTypeId() {
        return $this->requestStatusTypeId;
    }

    public function setRequestStatusTypeId($value) {
        return $this->requestStatusTypeId = $value;
    }

     public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }
}