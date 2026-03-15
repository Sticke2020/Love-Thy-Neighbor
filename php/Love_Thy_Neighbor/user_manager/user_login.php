<?php require_once '../view/header.php'; ?>

<h1 class="text-center mt-4 mb-3">Please Log in</h1>

   <?php  echo $errorMessage ?>
<form method="POST" action="user_manager/index.php" class="text-center">
   <input type="hidden" name="action" value="validate_login"> 

    <div class="mb-3">
        <label class='form-label fs-4'>Email: </label> 
        <input class="form-control form-control-lg mx-auto w-50" type="email" name="email" id="email" value="">
    </div>
    <div class="mb-4">
        <label class='form-label fs-4'>Password: </label> 
        <input class="form-control form-control-lg mx-auto w-50" type="password" name="password" id="password" value="">
    </div>
    <div class="mb-5 mt-5">
        <label></label>
        <input class="btn btn-lg bg-custom-white mx-auto w-50" type="submit" value="Login">
    </div>
</form>
<?php require_once '../view/footer.php'; ?>