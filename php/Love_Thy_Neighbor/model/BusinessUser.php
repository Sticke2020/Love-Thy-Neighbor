<?php

class BusinessUser {
    private $userId, $fullName, $businessId, $isAdmin; 


    // Getters and Setters
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        return $this->userId = $value;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($value) {
        return $this->fullName = $value;
    }

    public function getBusinessId() {
        return $this->businessId;
    }

    public function setBusinessId($value) {
        return $this->businessId = $value;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($value) {
        return $this->isAdmin = $value;
    }
}