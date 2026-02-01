<?php 
 require_once '../view/header.php'; 
?> 

<h1>Choose Account Type</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="register_account" /> 
    <p>Choose the type of account you will be creating</p>
    <p>If you are creating an account for yourself select Personal Account</p>
    <p>If you are creating as an Employee that is associated with a Business that has a Business Account already
        choose Employee Account</p>
    <p>If you are creating an account for a Business and are either the owner or representative of that Business
        choose Business Account</p>
  <div class="register">
      <label class='radio_label' for="personal_account">This is a Personal account</label>
      <input class="radio_input" type="radio" name="account_type" id="personal" value="PERSONAL" checked>
  </div>
  <div class="register">
      <label class='radio_label' for="employee_account">This is an Employee account</label>
      <input class="radio_input" type="radio" name="account_type" id="employee" value="EMPLOYEE">
  </div>
  <div class="register">
      <label class='radio_label' for="business_account">This is a Business account</label>
      <input class="radio_input" type="radio" name="account_type" id="business" value="BUSINESS">
  </div>
  <div class="register">
      <label class='label_form' for="button_next"></label>
      <input class="clickable_form" type="submit" id="button_next" value="Next">
  </div>

</form>
<?php require_once '../view/footer.php'; ?>