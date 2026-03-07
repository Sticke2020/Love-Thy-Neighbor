<?php 
 require_once '../view/user_header.php'; 
/** @var Business $business */  // <-- docblock to tell view $business is a Business object
?> 


<h1>Edit User Info</h1>
<fieldset>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="update_user" /> 
    <?php if ($user->getUserTypeId() != 3): ?>
        <div class="edit">
            <label>User Id</label>
            <input class="form_input" name="user_id" value="<?php echo htmlspecialchars($user->getID()); ?>" readonly>
        </div>
        <div class="edit">
            <label>User Type Id</label>
            <input class="form_input" name="user_type_id" value="<?php echo htmlspecialchars($user->getUserTypeId()); ?>" readonly>
        </div>
    <?php endif; ?>
    <div class="edit">
        <label>First Name</label>
        <input class="form_input" name="first_name" value="<?php echo htmlspecialchars($user->getFirstName()); ?>">
    </div>
    <div class="edit">
        <label>Last Name</label>
        <input class="form_input" name="last_name" value="<?php echo htmlspecialchars($user->getLastName()); ?>">
    </div>
    <div class="edit">
        <label>City</label>
        <input class="form_input" name="city" value="<?php echo htmlspecialchars($user->getCity()); ?>">
    </div>
    <div class="edit">
        <label>State</label>
        <input class="form_input" name="state" value="<?php echo htmlspecialchars($user->getState()); ?>">
    </div>
    <div class="edit">
        <label>Zip</label>
        <input class="form_input" name="zip" value="<?php echo htmlspecialchars($user->getZip()); ?>">
    </div>
    <div class="edit">
        <label>Email</label>
        <input class="form_input" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>">
    </div>
    <div class="edit">
        <label>Phone</label>
        <input class="form_input" name="phone" value="<?php echo htmlspecialchars($user->getPhone()); ?>">
    </div>
    <div class="edit">
        <label>UserName</label>
        <input class="form_input" name="user_name" value="<?php echo htmlspecialchars($user->getUserName()); ?>">
    </div>
    <div class="edit">
      <label></label>
      <input type="submit" value="Save Changes" class="form_input_button">
    </div>
</form>
</fieldset>

<h1>Edit Business Info</h1>  
<fieldset>  
<form action="business_manager/index.php" method="post">
<input type="hidden" name="action" value="update_business" />
<input type="hidden" name="business_id" value="<?php echo $business->getId(); ?>">
    <div class="edit">
        <label>Name</label>
        <input class="form_input" name="business_name" value="<?php echo htmlspecialchars($business->getName()); ?>">
    </div>
    <div class="edit">
        <label>Phone</label>
        <input class="form_input" name="business_phone" value="<?php echo htmlspecialchars($business->getPhone()); ?>">
    </div>
    <div class="edit">
        <label>Address</label>
        <input class="form_input" name="business_address" value="<?php echo htmlspecialchars($business->getAddress()); ?>">
    </div>
    <div class="edit">
        <label>City</label>
        <input class="form_input" name="business_City" value="<?php echo htmlspecialchars($business->getCity()); ?>">
    </div>
    <div class="edit">
        <label>State</label>
        <input class="form_input" name="business_state" value="<?php echo htmlspecialchars($business->getState()); ?>">
    </div>
    <div class="edit">
        <label>Zip</label>
        <input class="form_input" name="business_zip" value="<?php echo htmlspecialchars($business->getZip()); ?>">
    </div>
    <div class="edit">
        <label>Description</label>
        <textarea class="text_area" rows="8" name="business_description" id="business_description">
            <?php echo htmlspecialchars($business->getDescription()); ?>
        </textarea>
    </div>
    <div class="edit">
        <label>Verification Code</label>
        <input class="form_input" name="business_code" value="<?php echo htmlspecialchars($business->getVerificationCode()); ?>">
    </div>
    <div class="edit">
        <label></label>
        <input type="submit" value="Save Changes" class="form_input_button">
    </div>
</form>
</fieldset>

<h1>Change Password</h1>  
<fieldset>  
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="change_password" />
    <div class="edit">
        <label>Current Password</label>
        <input class="form_input" name="current_password" value="">
    </div>
    <div class="edit">
        <label>New Password</label>
        <input class="form_input" name="new_password" value="">
    </div>
    <div class="edit">
        <label>Re-Enter New Password</label>
        <input class="form_input" name="new_password_confirm" value="">
    </div>
    <div class="edit">
        <label></label>
        <input type="submit" value="Change Password" class="form_input_button">
    </div>
</form>
</fieldset>

<?php require_once '../view/footer.php'; ?>