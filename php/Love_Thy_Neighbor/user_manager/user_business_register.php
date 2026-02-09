<?php 
 require_once '../view/header.php'; 
?> 

<h1>Register Business</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="add_user_business" /> 
    <p>All fields are Required.</p>
    <p>A User account will be created and tied to your Business</p>

    <p>Enter your user info</p>
    <div class="register">
        <label class='label_form' for="first_name">First Name</label>
        <input class="text_input" type="text" name="first_name" id="first_name" required value="">
    </div>
    <div class="register">
        <label  class='label_form'for="last_name">Last Name</label>
        <input class="text_input" type="text" name="last_name" id="last_name" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="city">City</label>
        <input class="text_input" type="text" name="city" id="city" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="state">State</label>
        <input class="text_input" type="text" name="state" id="state" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="zip">Zip Code</label>
        <input class="text_input" type="text" name="zip" id="zip" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="phone">Phone</label>
        <input class="text_input" type="text" name="phone" id="phone" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="email">Email</label>
        <input class="text_input" type="text" name="email" id="email" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="user_name">UserName</label>
        <input class="text_input" type="text" name="user_name" id="user_name" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="password">Password</label>
        <input class="text_input" type="text" name="password" id="password" required value="">
    </div>

    <p>Enter your Business info</p>

    <div class="register">
        <label class='label_form' for="business_name">Business Name</label>
        <input class="text_input" type="text" name="business_name" id="business_name" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_phone">Phone</label>
        <input class="text_input" type="text" name="business_phone" id="business_phone" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_address">Address</label>
        <input class="text_input" type="text" name="business_address" id="business_address" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_city">City</label>
        <input class="text_input" type="text" name="business_city" id="business_city" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_state">State</label>
        <input class="text_input" type="text" name="business_state" id="business_state" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_zip">Zip</label>
        <input class="text_input" type="text" name="business_zip" id="business_zip" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="business_description">Description</label>
        <input class="text_input" type="text" name="business_description" id="business_description" required value="">
    </div>

    <p>Create a verification code and enter it below.</p>
    <p>This code will be used to verify your employees when they create Employee Accounts.</p> 
    <p>Your Employees will also need your Business ID which will be proviede after Registration.</p> 
    <p>Use a strong unique code. Dont lose this code, your employees must provide this code when creating an Employee Account.</p>

    <div class="register">
        <label class='label_form' for="business_code">Verification Code</label>
        <input class="text_input" type="text" name="business_code" id="business_code" required value="">
    </div>
    <div class="register">
        <label class='label_form' for="button_register"></label>
        <input class="clickable_form" type="submit" id="button_register" value="Register">
    </div>
</form>
<?php require_once '../view/footer.php'; ?>