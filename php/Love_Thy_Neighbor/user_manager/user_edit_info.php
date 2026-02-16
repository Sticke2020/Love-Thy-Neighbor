<?php 
 require_once '../view/user_header.php'; 
?> 

<h1>Edit User</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="update_user" />
    <div>
        <label>User Id</label>
        <input name="user_id" value="<?php echo $user->getID(); ?>" readonly>
    </div>
    <div>
        <label>User Type Id</label>
        <input name="user_type_id" value="<?php echo $user->getUserTypeId(); ?>" readonly>
    </div>
    <div>
        <label>First Name</label>
        <input name="first_name" value="<?php echo $user->getFirstName(); ?>">
    </div>
    <div>
        <label>Last Name</label>
        <input name="last_name" value="<?php echo $user->getLastName(); ?>">
    </div>
    <div>
        <label>City</label>
        <input name="city" value="<?php echo $user->getCity(); ?>">
    </div>
    <div>
        <label>State</label>
        <input name="state" value="<?php echo $user->getState(); ?>">
    </div>
    <div>
        <label>Zip</label>
        <input name="zip" value="<?php echo $user->getZip(); ?>">
    </div>
    <div>
        <label>Email</label>
        <input name="email" value="<?php echo $user->getEmail(); ?>">
    </div>
    <div>
        <label>Phone</label>
        <input name="phone" value="<?php echo $user->getPhone(); ?>">
    </div>
    <div>
        <label>UserName</label>
        <input name="user_name" value="<?php echo $user->getUserName(); ?>">
    </div>
    <div>
        <label>Password</label>
        <input name="password" value="<?php echo $user->getPassword(); ?>">
    </div>
</form>

<?php require_once '../view/footer.php'; ?>