<?php

class BusinessUser {
    private $userId, $businessId; 


    // Getters and Setters
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        return $this->userId = $value;
    }

    public function getBusinessId() {
        return $this->businessId;
    }

    public function setBusinessId($value) {
        return $this->businessId = $value;
    }
}
?>