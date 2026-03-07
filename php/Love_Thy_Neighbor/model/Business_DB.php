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

    $query = 'SELECT * FROM business WHERE id = :businessId';

    $statement = $db->prepare($query);
    $statement->bindValue(':businessId', $businessId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    $business = new Business();
        $business->setId($row['id']);
        $business->setName($row['name']);
        $business->setPhone($row['phone']);
        $business->setAddress($row['address']);
        $business->setCity($row['city']);
        $business->setState($row['state']);
        $business->setZip($row['zip']);
        $business->setDescription($row['description']);
        $business->setVerificationCode($row['verification_code']);
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

/*******************************************************************************************************
public static function getBusinessByUserId($userId) {
    $db = DataBase::getDB();

    $query = 'SELECT business_id FROM business_user
            WHERE user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $businessId = $statement->fetchColumn(0);
    $statement->closeCursor();

    $businessId = $businessId;
    
    $query = 'SELECT * FROM business
            WHERE id = :businessId';

    $statement = $db->prepare($query);
    $statement->bindValue(':businessId', $businessId);
    $statement->execute();

    foreach ($statement as $row) {
        $business = new Business();
        $business->setId($row['id']);
        $business->setName($row['name']);
        $business->setPhone($row['phone']);
        $business->setAddress($row['address']);
        $business->setCity($row['city']);
        $business->setState($row['state']);
        $business->setZip($row['zip']);
        $business->setDescription($row['description']);
    }

    $statement->closeCursor();

    return $business;
}
*************************************************************************************************************/

// Checks to see if a user is also a business user
public static function isBusinessUser($userId) {
    $businessUser = false;

    $db = DataBase::getDB();

    $query = 'SELECT user_id FROM business_user
            WHERE user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $businessUserId = $statement->fetchColumn(0);
    $statement->closeCursor();
    
    if ($businessUserId !== false) {
        $businessUser = true;
    }
    return $businessUser;
}

public static function getBusinessUserByUserId($userId) {
    $db = DataBase::getDB();

    $query = 'SELECT user_id, business_id, is_admin FROM business_user
            WHERE user_id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    $businessUser = new BusinessUser();
        $businessUser->setUserId($user['user_id']);
        $businessUser->setBusinessId($user['business_id']);
        $businessUser->setIsAdmin($user['is_admin']);

    return $businessUser;
}

public static function updateBusiness($business) {
    $id = $business->getId();
    $name = $business->getName();
    $phone = $business->getPhone();
    $address = $business->getAddress();
    $city = $business->getCity();
    $state = $business->getState();
    $zip = $business->getZip();
    $description = $business->getDescription();
    $code = $business->getVerificationCode();

    $db = DataBase::getDB();

    $query = 'UPDATE business
                SET
                    name = :name, phone = :phone, address = :address, city = :city,
                    state = :state, zip = :zip, description = :description, verification_code = :code
                WHERE
                    id = :id';

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':name', $name);
    $statement->bindvalue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->bindvalue(':city', $city);
    $statement->bindvalue(':state', $state);
    $statement->bindvalue(':zip', $zip);
    $statement->bindvalue(':description', $description);
    $statement->bindvalue(':code', $code);
    $statement->execute();
    $statement->closeCursor();
}

}
