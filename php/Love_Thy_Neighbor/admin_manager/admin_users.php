<?php require_once ('../view/admin_header.php'); ?>
<section>


<!--------------------- User search ------------------->
<div class="d-flex justify-content-center">
    <form action="admin_manager/index.php" method="POST" class="mb-2 mt-2">
        <label id="search" class="w-100">Search Users By id . :</label>
        <input class='text_input' type="text" name="search_id">
        <input type="hidden" name="action" value="search_users_by_id" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</div>
<div class="d-flex justify-content-center">
    <form action="admin_manager/index.php" method="POST" class="mb-2">
        <label id="search" class="w-100">Search By UserName:</label>
        <input class='text_input' type="text" name="search_username">
        <input type="hidden" name="action" value="search_users_by_username" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</div>
<div class="d-flex justify-content-center">
    <form action="admin_manager/index.php" method="POST">
        <label id="search" class="w-100">Search By LastName:</label>
        <input class='text_input' type="text" name="search_lastname">
        <input type="hidden" name="action" value="search_users_by_lastname" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</div>


<!-------------------------- Table of users ------------------------->
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-custom-blue text-white">
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
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : $id = $user->getId(); ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $user->getUserTypes(); ?></td>
                            <td><?php echo htmlspecialchars($user->getUserName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getLastName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getEmail()); ?></td>

                            <td class="text-center">
                                <div class="d-flex gap-2">

                                    <form action="user_manager/index.php" method="POST">
                                        <input type="hidden" name="action" value="view_user">
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                        <button class="btn btn-md btn-primary">View</button>
                                    </form>

                                    <form action="user_manager/index.php" method="POST">
                                        <input type="hidden" name="action" value="edit_user">
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                        <button class="btn btn-md btn-warning">Edit</button>
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