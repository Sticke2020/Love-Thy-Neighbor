<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

    <p>Your changes have been saved</p>

<?php require_once '../view/footer.php'; ?>