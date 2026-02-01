<?php 
 require_once '../view/header.php'; 
?> 

<h1>Register User</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="controllerRequest" value="add_user" /> 
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
      <label class='label_form' for="username">Username</label>
      <input class="text_input" type="text" name="password" id="password"
          required value="">
  </div>
  <div class="register">
      <label class='label_form' for="password">Password</label>
      <input class="text_input" type="text" name="password" id="password"
          required value="">
  </div>
  <div class="register">
      <label class='radio_label' for="personal_account">This is a Personal account</label>
      <input class="radio_input" type="radio" name="account_type" id="personal" value="personal" checked>
  </div>
  <div class="register">
      <label class='radio_label' for="employee_account">This is an Employee account</label>
      <input class="radio_input" type="radio" name="account_type" id="employee" value="employee">
  </div>
  <div class="register">
      <label class='radio_label' for="business_account">This is a Business account</label>
      <input class="radio_input" type="radio" name="account_type" id="business" value="business">
  </div>
  <div class="register">
      <label class='label_form' for="button_register"></label>
      <input class="clickable_form" type="submit" id="button_register" value="Register">
  </div>

</form>
<?php require_once '../view/footer.php'; ?>