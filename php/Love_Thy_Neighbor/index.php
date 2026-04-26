<?php 
require_once("model/DataBase.php");
require_once("model/User.php");
require_once("model/User_DB.php");
require_once("model/BusinessUser.php");

$disclaimer = <<<disc
Legal Disclaimer,
This website is intended for use by adults age 18 and up.
You may meet people from this site in the real world with the 
intention of giving or receiving help. Since users of this site
may meet in the real world it is not intended for users under the
age of 18. Users of the site found to be under the age of 18 will
have their account terminated immediately. By creating an account
you agree that you are 18 years of age or older. By creating an 
account you also agree that you will not use this site for any 
malicious purposes or illegal activity. By creating an account 
you also agree that the creator and maintainers of the site cannot
and will not be held liable for any action you take or any actions 
taken against you as a result of using this site. You are solely 
responsible for your own words and actions.
disc; 

if(session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 14;
    session_name('userSession');
    session_set_cookie_params($lifetime, '/');
    session_start();
}
if (isset($_SESSION['userId'])) {
    $sessionDetails = "Welcome ";
    $user = UserDB::getUserById($_SESSION['userId']);
    $header = null;
    if ($user->getUserTypeId() == 3) {
        $header = 'view/user_header.php';
    }
    if ($user->getUserTypeId() == 1) {
        $header = 'view/admin_header.php';
    }
    $messageWelcome = "You are Still Logged In";
} else {
     $sessionDetails = "User Not Logged In.";
    $header = 'view/header.php';
    $messageWelcome = "Welcome";
}
?>

<?php require_once $header; ?>

<h1 class="text-center mt-3"><?php echo $sessionDetails ?></h1><br>
<h1 class="text-center"><?php echo $messageWelcome ?></h1><br>
<h2 class="text-center bg-custom-red custom-border-outset mt-1 p-3"><?php echo $disclaimer ?></h2>


<fieldset class="w-25">
<p class="mt-3 fs-5">This button will hash the passwords in the DB if the DB was reset and the passwords are plain text</p>
<div class="mt-1">
    <form method="POST" action="admin_manager/index.php">
        <input type="hidden" name="action" value="hash_passwords">
        <input type="submit" class="btn btn-lg bg-custom-black text-custom-white" value="Hash Passwords">
    </form>
</div>
</fieldset>


<?php require_once 'view/footer.php'; ?>