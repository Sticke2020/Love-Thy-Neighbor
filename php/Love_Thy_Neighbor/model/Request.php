<?php

class Request {
    private $id, $userId, $title, $body, $userName, $userImage, $requestStatusTypeId, $dateCreated, $dateUpdated;

    // So requests can hold more than 1 image
    private $images = [];

    public function __construct() {}

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

    public function getUserImage() {
        return $this->userImage;
    }

    public function setUserImage($value) {
        return $this->userImage = $value;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($value) {
        return $this->userName = $value;
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

    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    public function setDateUpdated($value) {
        return $this->dateUpdated = $value;
    }

    public function addImage($image) {
        $this->images[] = $image;
    }

    public function getImages() {
        return $this->images;
    }
}