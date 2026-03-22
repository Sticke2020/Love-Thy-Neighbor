<?php

class Message {
    private $id, $senderId, $sender, $receiverId, $body, $dateCreated, $isRead;

    public function __construct() {}
   
    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function setId($value) {
        return $this->id = $value;
    }

    public function getSenderId() {
        return $this->senderId;
    }

    public function setSenderId($value) {
        return $this->senderId = $value;
    }

    public function getSender() {
        return $this->sender;
    }

    public function setSender($value) {
        return $this->sender = $value;
    }

    public function getReceiverId() {
        return $this->receiverId;
    }

    public function setReceiverId($value) {
        return $this->receiverId = $value;
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

    public function getIsRead() {
        return $this->isRead;
    }

    public function setIsRead($value) {
        return $this->isRead = $value;
    }
}