<?php require_once '../view/header.php'; ?>
<h1>Please Log in</h1>

   <?php  echo $errorMessage ?>
   <form method="POST" action="user_manager/index.php">
   <input type="hidden" name="action" value="validate_login">  
    <div class="login">
        <label class='label_form'>Email: </label> 
        <input class="text_input" type="email" name="email" id="email" value="">
    </div>
    <div class="login">
        <label class='label_form'>Password: </label> 
        <input class="text_input" type="password" name="password" id="password" value="">
    </div>
    <div class="login">
        <label></label>
        <input class="clickable_form" type="submit" value="Login">
    </div>
</form>
<?php require_once '../view/footer.php'; ?>