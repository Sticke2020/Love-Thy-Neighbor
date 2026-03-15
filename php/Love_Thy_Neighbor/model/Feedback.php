<?php

class Feedback {
    private $id, $sender, $senderImage, $receiverId, $comment, $dateCreated;

    public function __construct() {}
   
    // Getters and Setters

    public function getId() {
        return $this->id;
    } 

    public function setId($value) {
        return $this->id = $value;
    }

    public function getSender() {
        return $this->sender;
    }

    public function setSender($value) {
        return $this->sender = $value;
    }

    public function getSenderImage() {
        return $this->senderImage;
    }

    public function setSenderImage($value) {
        return $this->senderImage = $value;
    }

    public function getReceiverId() {
        return $this->receiverId;
    }

    public function setReceiverId($value) {
        return $this->receiverId = $value;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($value) {
        return $this->comment = $value;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($value) {
        return $this->dateCreated = $value;
    }

}