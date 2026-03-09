<?php require_once ('../view/admin_header.php'); ?>
<section>

<fieldset>
    <form action="admin_manager/index.php" method="POST">
        <label id="search">Search Users By UserName:</label>
        <input class='text_input' type="text" name="search_username">
        <input type="hidden" name="action" value="search_users_by_username" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</fieldset>
<fieldset>
    <table>
        <tr>
            <th>Id</th>
            <th>UserTypeId</th>
            <th>UserName</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>ViewProfile</th>
            <th>EditUser</th>
        </tr>
        <?php foreach ($users as $user) :?>
            <tr>
                <td><?php echo $user->getId(); ?></td>
                <td><?php echo $user->getUserTypeId(); ?></td>
                <td><?php echo $user->getUserName(); ?></td>
                <td><?php echo $user->getFirstName(); ?></td>
                <td><?php echo $user->getLastName(); ?></td>
                <td>
                    <form  action="admin_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="view_user" />
                        <input type="hidden" name="user_id" value="<?php echo $user->getID(); ?>">
                        <input type="submit" value="View User">
                    </form>
                </td>
                <td>
                    <form  action="admin_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="edit_user" />
                        <input type="hidden" name="user_id" value="<?php echo $user->getID(); ?>">
                        <input type="submit" value="Edit User">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>

</section>

<?php require_once ('../view/footer.php'); ?>