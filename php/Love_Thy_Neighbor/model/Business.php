<?php 

class Business {
    private $id, 
            $name, 
            $phone,
            $address,
            $city, 
            $state, 
            $zip,
            $description,
            $verificationCode,
            $dateCreated;


    public function __construct() {}

    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function setId($value) {
        return $this->id = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        return $this->name = $value;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($value) {
        return $this->phone = $value;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($value) {
        return $this->address = $value;
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

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        return $this->description = $value;
    }

    public function getVerificationCode() {
        return $this->verificationCode;
    }

    public function setVerificationCode($value) {
        return $this->verificationCode = $value;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }

}
