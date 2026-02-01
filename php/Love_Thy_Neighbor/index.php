<?php 
require_once("model/User.php");
if(session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 14;
    session_name('userSession');
    session_set_cookie_params($lifetime, '/');
    session_start();
}
if (isset($_SESSION['user'])) {
    $sessionDetails = "Welcome " . $_SESSION['user']->getFirstName() . " " . $_SESSION['user']->getLastName();
    $header = 'view/user_header.php';
    $messageWelcome = "You are Still Logged In";
    $messageWelcomeContinued = "From a previous SESSION";
} else {
     $sessionDetails = "User Not Logged In.";
    $header = 'view/header.php';
    $messageWelcome = "Welcome";
}


?>
<?php require_once $header; ?>

 <h1><?php echo $messageWelcome ?></h1><br>

<?php require_once 'view/footer.php'; ?>