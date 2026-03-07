<?php
require_once("User.php");

class UserDB {

public static function getUserByEmailAndPassword($email, $password) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user WHERE email_address = :email';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        $selectedUser = new User();

        if ($user == false) {
            $selectedUser->setId(null);
            return $selectedUser;
        }

        if (password_verify($password, $user['password'])) {
            $selectedUser->setID($user['id']);
        }
        else {
            $selectedUser->setId(null);
        }
        
    return $selectedUser;
}

public static function getUserByEmail($email) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user WHERE email_address = :email';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        $selectedUser = new User();

        if ($user == false) {
            $selectedUser->setId(null);
        }
        else {
            $selectedUser->setID($user['id']);
        }
        
    return $selectedUser;
}


public static function getUserById($ID) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user WHERE id = :ID';

    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    $selectedUser = new User();
        $selectedUser->setId($user['id']);
        $selectedUser->setUserTypeId($user['user_type_id']);
        $selectedUser->setFirstName($user['first_name']);
        $selectedUser->setLastName($user['last_name']);
        $selectedUser->setCity($user['city']);
        $selectedUser->setState($user['state']);
        $selectedUser->setZip($user['zip']);
        $selectedUser->setEmail($user['email_address']);
        $selectedUser->setPhone($user['phone']);
        $selectedUser->setUserName($user['username']);
        $selectedUser->setPassword($user['password']);
        $selectedUser->setProfileImageId($user['profile_image_id']);
    return $selectedUser;
}

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

public static function userNameExists($userName, $excludeId = null) {
    $db = DataBase::getDB();

    if ($excludeId) {
        $query = 'SELECT COUNT(*) FROM user
                    WHERE username = :userName AND id != :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $userName);
        $statement->bindValue(':id', $excludeId);
    }
    else {
        $query = 'SELECT COUNT(*) FROM user 
                WHERE username = :userName';
        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $userName);
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
    $userName = $user->getUserName();
    $password = $user->getPassword();
    $userTypeId = $user->getUserTypeId();


    $db = DataBase::getDB();
    $query = 'INSERT INTO user
            (user_type_id, first_name, last_name, city, state, zip, email_address, phone, username, password)
        VALUES
            (:userTypeId, :firstName, :lastName, :city, :state, :zip, :email, :phone, :userName, :password)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userTypeId', $userTypeId);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindvalue(':city', $city);
    $statement->bindvalue(':state', $state);
    $statement->bindvalue(':zip', $zip);
    $statement->bindvalue(':email', $email);
    $statement->bindvalue(':phone', $phone);
    $statement->bindvalue(':userName', $userName);
    $statement->bindvalue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

public static function setUserProfilePic($userId, $imageId) {
    $db = DataBase::getDB();

    $query = 'UPDATE user
            SET profile_image_id = :imageId
            WHERE id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':imageId', $imageId);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

public static function updateUser($user) {

}

/*  REMOVE THIS METHOD BEFORE FINAL PRODUCTION ********************************************
public static function hashPasswordsInDB() {
    $db = DataBase::getDB(); 
    
    $query = 'SELECT id, password
    FROM user';
    $statement = $db->prepare($query);
    $statement->execute();

    $users = array();
    foreach ($statement as $row) {
        $user = new User();
        $user->setID($row['id']);
        $user->setPassword($row['password']);

        $users[] = $user;
    }
    foreach ($users as $user) {
        $password = $user->getPassword();

        if (strlen($password) === 60 && str_starts_with($password, '$2y$')) {
            continue;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = 'UPDATE user SET password = :password WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':password', $hashedPassword);
        $statement->bindValue(':id', $user->getId());
        $statement->execute();
    }
}
***********************************************************************************************/


}