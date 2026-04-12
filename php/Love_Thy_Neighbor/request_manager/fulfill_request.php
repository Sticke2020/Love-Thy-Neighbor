<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<div class="text-center fs-3 mt-3">
    <p>Thank you for wanting to fulfill this request. </p>
    <p>The user who created the request has been informed</p>
    <p>that you are interested in fulfilling it.</p>
    <p>You can also send the user a message if you dont hear back soon.</p>
</div>

<?php require_once '../view/footer.php'; ?>