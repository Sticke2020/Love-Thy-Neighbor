<?php

class Image {
    private $id, $userId, $fileName, $fileUrl, $fileSizeBytes, $dateCreated, $requestId;

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

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($value) {
        return $this->fileName = $value;
    }

    public function getFileUrl() {
        return $this->fileUrl;
    }

    public function setFileUrl($value) {
        return $this->fileUrl = $value;
    }

    public function getFileSizeBytes() {
        return $this->fileSizeBytes;
    }

    public function setFileSizeBytes($value) {
        return $this->fileSizeBytes = $value;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }

    public function getRequestId() {
        return $this->requestId;
    }

    public function setRequestId($value) {
        return $this->requestId = $value;
    }
}