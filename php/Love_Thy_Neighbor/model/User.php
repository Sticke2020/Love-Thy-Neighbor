<?php 

class User {
    private $id,
            $userTypeId, 
            $firstName, 
            $lastName,
            $city, 
            $state, 
            $zip,
            $email, 
            $phone, 
            $userName,
            $password,
            $dateCreated;

    public function __construct() {}

    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function getUserTypeId() {
        return $this->userTypeId;
    }

    public function setUserTypeId($value) {
        return $this->userTypeId = $value;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($value) {
        return $this->firstName = $value;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($value) {
        return $this->lastName = $value;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($value) {
        return $this->city = $value;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($value) {
        return $this->state = $value;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($value) {
        return $this->zip = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        return $this->email = $value;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($value) {
        return $this->phone = $value;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($value) {
        return $this->userName = $value;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        return $this->password = $value;
    }

     public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }
}

?>