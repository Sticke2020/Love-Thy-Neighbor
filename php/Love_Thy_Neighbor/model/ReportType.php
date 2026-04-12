<?php

class ReportType {
    private $id, $description;

    public function __construct() {}

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        return $this->id = $value;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        return $this->description = $value;
    }

}