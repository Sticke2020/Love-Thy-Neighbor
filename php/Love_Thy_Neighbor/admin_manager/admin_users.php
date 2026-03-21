<?php require_once ('../view/admin_header.php'); ?>
<section>

<fieldset class="m-2">
    <form action="admin_manager/index.php" method="POST">
        <label id="search">Search Users By UserName:</label>
        <input class='text_input' type="text" name="search_username">
        <input type="hidden" name="action" value="search_users_by_username" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</fieldset>


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Manage Users</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>User Type</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user) :
                            $id = $user->getId();
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $user->getUserTypeId(); ?></td>
                            <td><?php echo htmlspecialchars($user->getUserName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getLastName()); ?></td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <form action="admin_manager/index.php" method="POST">
                                        <input type="hidden" name="action" value="view_user">
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                        <button class="btn btn-sm btn-primary">View</button>
                                    </form>

                                    <form action="admin_manager/index.php" method="POST">
                                        <input type="hidden" name="action" value="edit_user">
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>