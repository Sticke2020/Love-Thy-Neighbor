<?php

class Log {
    private $id, $userId, $actionTypeId, $dateCreated;

    public function __construct($userId, $actionTypeId) {
        $this->userId = $userId;
        $this->actionTypeId = $actionTypeId;
    }

    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function setId($value) {
        return $this->id = $value;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        return $this->userId = $value;
    }

    public function getActionTypeId() {
        return $this->actionTypeId;
    }

    public function setActionTypeId($value) {
        return $this->actionTypeId = $value;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }
}
