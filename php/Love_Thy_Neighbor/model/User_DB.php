<?php
require_once("User.php");

class UserDB {

public static function confirmUserPassword($userId, $password) {
    $isCorrectPassword = false;

    $db = DataBase::getDB();

    $query = 'SELECT * FROM user WHERE id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if (password_verify($password, $user['password'])) {
        $isCorrectPassword = true;
    }
    return $isCorrectPassword; 
}

public static function getUsers() {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user';

    $statement = $db->prepare($query);
    $statement->execute();

    $users = array();
    foreach ($statement as $row) {
        $user = new User();
        $user->setId($row['id']);
        $user->setUserTypeId($row['user_type_id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setZip($row['zip']);
        $user->setEmail($row['email_address']);
        $user->setPhone($row['phone']);
        $user->setUserName($row['username']);
        $user->setProfileImageId($row['profile_image_id']);
        $user->setDateCreated($row['date_created']);
        $user->setDateUpdated($row['date_updated']);

        $users[] = $user;
    }
    return $users;
}

public static function getUserNames() {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user';

    $statement = $db->prepare($query);
    $statement->execute();

    $users = array();
    foreach ($statement as $row) {
        $user = new User();
        $user->setUserName($row['username']);

        $users[] = $user;
    }
    return $users;
}

public static function getUserIdByRequestId($requestId) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM request WHERE id = :requestId';

        $statement = $db->prepare($query);
        $statement->bindValue(':requestId', $requestId);
        $statement->execute();
        $request = $statement->fetch();
        $statement->closeCursor();

        $user = new User();

        if ($request == false) {
            $user->setId(null);
        }
        else {
            $user->setId($request['user_id']);
        }
        
    return $user;
}

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
            $selectedUser->setId($user['id']);
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

public static function getUserByUserName($userName) {
    $db = DataBase::getDB();

    $query = 'SELECT * FROM user WHERE username = :userName';

        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $userName);
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

public static function searchUsersByUserName($userName) {
    $db = DataBase::getDB();

    if ($userName != '') {	
        $userName = '%'.$userName.'%';
        $query = 'SELECT * FROM user WHERE username like :userName ORDER BY id';
        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $userName);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }
    else {
        $query = 'SELECT * FROM user
                        ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }

    $userArray = array();
    foreach ($users as $row) {
        $user = new User();
        $user->setID($row['id']);
        $user->setUserTypeId($row['user_type_id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setZip($row['zip']);
        $user->setEmail($row['email_address']);
        $user->setPhone($row['phone']);
        $user->setUserName($row['username']);
        $user->setPassword($row['password']);
        $user->setProfileImageId($row['profile_image_id']);
        $user->setDateCreated($row['date_created']);
        $user->setDateUpdated($row['date_updated']);

        $userArray[] = $user;
    }
    return $userArray;
}

public static function searchUsersByLastName($lastName) {
    $db = DataBase::getDB();

    if ($lastName != '') {	
        $lastName = '%'.$lastName.'%';
        $query = 'SELECT * FROM user WHERE last_name like :lastName ORDER BY id';
        $statement = $db->prepare($query);
        $statement->bindValue(':lastName', $lastName);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }
    else {
        $query = 'SELECT * FROM user
                        ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }

    $userArray = array();
    foreach ($users as $row) {
        $user = new User();
        $user->setID($row['id']);
        $user->setUserTypeId($row['user_type_id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setZip($row['zip']);
        $user->setEmail($row['email_address']);
        $user->setPhone($row['phone']);
        $user->setUserName($row['username']);
        $user->setPassword($row['password']);
        $user->setProfileImageId($row['profile_image_id']);
        $user->setDateCreated($row['date_created']);
        $user->setDateUpdated($row['date_updated']);

        $userArray[] = $user;
    }
    return $userArray;
}

public static function searchUsersById($id) {
    $db = DataBase::getDB();

    if ($id != '') {	
        $id = '%'.$id.'%';
        $query = 'SELECT * FROM user WHERE id like :id ORDER BY id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }
    else {
        $query = 'SELECT * FROM user
                        ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
    }

    $userArray = array();
    foreach ($users as $row) {
        $user = new User();
        $user->setID($row['id']);
        $user->setUserTypeId($row['user_type_id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setZip($row['zip']);
        $user->setEmail($row['email_address']);
        $user->setPhone($row['phone']);
        $user->setUserName($row['username']);
        $user->setPassword($row['password']);
        $user->setProfileImageId($row['profile_image_id']);
        $user->setDateCreated($row['date_created']);
        $user->setDateUpdated($row['date_updated']);

        $userArray[] = $user;
    }
    return $userArray;
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
            SET profile_image_id = :imageId, date_updated = NOW()
            WHERE id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':imageId', $imageId);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
}

public static function updateUser($user) {
    $userId = $user->getID();
    $userTypeId = $user->getUserTypeID();
    $firstName = $user->getFirstName();
    $lastName = $user->getLastName();
    $city = $user->getCity();
    $state = $user->getState();
    $zip = $user->getZip();
    $email = $user->getEmail();
    $phone = $user->getPhone();
    $userName = $user->getUserName();

    $db = DataBase::getDB();
    $query = 'UPDATE user
                SET 
                    user_type_id = :userTypeId, first_name = :firstName, last_name = :lastName,
                    city = :city, state = :state, zip = :zip, email_address = :email, 
                    phone = :phone, username = :userName, date_updated = NOW()
                WHERE
                    id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':userTypeId', $userTypeId);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindvalue(':city', $city);
    $statement->bindvalue(':state', $state);
    $statement->bindvalue(':zip', $zip);
    $statement->bindvalue(':phone', $phone);
    $statement->bindvalue(':email', $email);
    $statement->bindvalue(':userName', $userName);
    $statement->execute();
    $statement->closeCursor();
}

public static function updatePassword($userId, $hashedPassword) {
    $db = DataBase::getDB();
    $query = 'UPDATE user
                SET 
                    password = :hashedPassword, date_updated = NOW()
                WHERE
                    id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindvalue(':hashedPassword', $hashedPassword);
    $statement->execute();
    $statement->closeCursor();
}

public static function deleteUser($userId) {
    $db = DataBase::getDB();

    $query = 'DELETE FROM user
                WHERE id = :userId';

    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $statement->closeCursor();
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