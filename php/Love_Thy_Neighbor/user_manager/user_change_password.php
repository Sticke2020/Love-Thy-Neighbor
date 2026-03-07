<?php 
 require_once '../view/user_header.php'; 
?> 

<h1>Edit User</h1>
<form action="user_manager/index.php" method="post">
<input type="hidden" name="action" value="update_user" /> 

    <div>
        <form action="user_manager/index.php" method="post">
        <input type="hidden" name="action" value="change_password" />
        <label>Password</label>
        <div>
            <label>Current Password</label>
            <input name="current_password" value="">
        </div>
        <div>
            <label>New Password</label>
            <input name="new_password" value="">
        </div>
        <div>
            <label>Re-Enter New Password</label>
            <input name="new_password_confirm" value="">
        </div>
        <input type="submit" value="Change Password">
    </div>

</form>

<?php require_once '../view/footer.php'; ?>