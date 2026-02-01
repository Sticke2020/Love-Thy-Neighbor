<?php
require_once("User.php");

class UserDB {

public static function emailAddressExists($email, $excludeId = null) {
    $db = DataBase::getDB();

    if ($excludeId) {
        $query = 'SELECT COUNT(*) FROM user
                    WHERE email_address = :email AND id != :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':id', $excludeId);
    }
    else {
        $query = 'SELECT COUNT(*) FROM user 
                WHERE email_address = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
    }

    $statement->execute();
    $count = $statement->fetchColumn();
    $statement->closeCursor();

    return $count;
}

public static function createUser($user) {
    $firstName = $user->getFirstName();
    $lastName = $user->getLastName();
    $city = $user->getCity();
    $state = $user->getState();
    $zip = $user->getZip();
    $phone = $user->getPhone();
    $email = $user->getEmail();
    $username = $user->getUsername();
    $password = $user->getPassword();
    $userTypeId = $user->getUserTypeId();


    $db = DataBase::getDB();
    $query = 'INSERT INTO user
            (user_type_id, first_name, last_name, city, state, zip, email_address, phone, username, password)
        VALUES
            (:userTypeId, :firstName, :lastName, :city, :state, :zip, :email, :phone, :username, :password)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userTypeId', $userTypeId);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindvalue(':city', $city);
    $statement->bindvalue(':state', $state);
    $statement->bindvalue(':zip', $zip);
    $statement->bindvalue(':email', $email);
    $statement->bindvalue(':phone', $phone);
    $statement->bindvalue(':username', $username);
    $statement->bindvalue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

}
?>