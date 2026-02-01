<?php 
 require_once '../view/header.php'; 
?> 

<h1>Register Employee</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="add_user" /> 
    <p>All fields are Required.</p>
    <div class="register">
        <label class='label_form' for="first_name">First Name</label>
        <input class="text_input" type="text" name="first_name" id="first_name"
            required value="">
    </div>
    <div class="register">
        <label  class='label_form'for="last_name">Last Name</label>
        <input class="text_input" type="text" name="last_name" id="last_name"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="city">City</label>
        <input class="text_input" type="text" name="city" id="city"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="state">State</label>
        <input class="text_input" type="text" name="state" id="state"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="zip">Zip Code</label>
        <input class="text_input" type="text" name="zip" id="zip"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="phone">Phone</label>
        <input class="text_input" type="text" name="phone" id="phone"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="email">Email</label>
        <input class="text_input" type="text" name="email" id="email"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="user_name">UserName</label>
        <input class="text_input" type="text" name="user_name" id="user_name"
            required value="">
    </div>
    <div class="register">
        <label class='label_form' for="password">Password</label>
        <input class="text_input" type="text" name="password" id="password"
            required value="">
    </div>

    <p>Enter the code provided by your employer for varification</p>

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