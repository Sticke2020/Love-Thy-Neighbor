<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?> 

<div class="text-center fs-3 mt-3">
    <h1 class="top">Error Page</h1>
    <p class="first_paragraph"><?php  if(isset($error)) echo $error; ?></p>
    <p><a href = "javascript:history.back()">Back to previous page</a></p>
</div>

<?php require_once '../view/footer.php'; ?>