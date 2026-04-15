<?php 
require_once("model/DataBase.php");
require_once("model/User.php");
require_once("model/User_DB.php");
require_once("model/BusinessUser.php");

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