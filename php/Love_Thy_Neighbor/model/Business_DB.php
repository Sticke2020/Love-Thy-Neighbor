<?php
require_once("Business.php");

class BusinessDB {

public static function createBusiness($business) {
    $name = $business->getName();
    $phone = $business->getPhone();
    $address = $business->getAddress();
    $city = $business->getCity();
    $state = $business->getState();
    $zip = $business->getZip();
    $description = $business->getDescription();
    $code = $business->getVerificationCode();

    $db = DataBase::getDB();

    $query = 'INSERT INTO business
                (name, phone, address, city, state, zip, description, verification_code)
            VALUES
                (:name, :phone, :address, :city, :state, :zip, :description, :code)';

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':zip', $zip);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':code', $code);
    $statement->execute();  
    $statement->closeCursor();
}

public static function getBusinessById($businessId) {
    $db = DataBase::getDB();

    $query = 'SELECT id, name, verification_code
                FROM business WHERE id = :businessId';

    $statement = $db->prepare($query);
    $statement->bindValue(':businessId', $businessId);
    $statement->execute();

    foreach ($statement as $row) {
        $business = new Business();
        $business->setId($row['id']);
        $business->setName($row['name']);
        $business->setVerificationCode($row['verification_code']);
    }
    return $business;
}

public static function getBusinessByName($name) {
    $db = DataBase::getDB();

    $query = 'SELECT id, name, verification_code
                FROM business WHERE name = :name';

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();

    foreach ($statement as $row) {
        $business = new Business();
        $business->setId($row['id']);
        $business->setName($row['name']);
        $business->setVerificationCode($row['verification_code']);
    }
    return $business;
}

public static function createBusinessUser($userId, $businessId, $isAdmin) {
    $db = DataBase::getDB();

    $query = 'INSERT INTO business_user
                (user_id, business_id, is_admin)
            VALUES
                (:userId, :businessId, :isAdmin)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':businessId', $businessId);
    $statement->bindValue(':isAdmin', $isAdmin);
    $statement->execute();  
    $statement->closeCursor();
}

}
?>