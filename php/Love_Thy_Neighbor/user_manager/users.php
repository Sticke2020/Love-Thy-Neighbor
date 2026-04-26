<?php require_once ('../view/user_header.php'); ?>

<div class="d-flex flex-column flex-md-row justify-content-center gap-4 fs-4 mt-3">
    
    <form action="user_manager/index.php" method="POST">
        <label class="w-100">Search By UserName:</label>
        <input class="text_input" type="text" name="search_username">
        <input type="hidden" name="action" value="search_users_by_username"> 
        <input class="clickable" type="submit" value="Search">
    </form>

    <form action="user_manager/index.php" method="POST" class="d-none d-md-table-cell">
        <label class="w-100">Search By LastName:</label>
        <input class="text_input" type="text" name="search_lastname">
        <input type="hidden" name="action" value="search_users_by_lastname"> 
        <input class="clickable" type="submit" value="Search">
    </form>

</div>

<div class="container-fluid mt-4 w-100 p-0">
    <div class="card custom-border-outset">
        <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
            <h3 class="mb-0">Users</h3>
        </div>
        <!-------------------------- Users Table --------------------->
        <div class="card-body bg-custom-blue">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle custom-border-outset">
                    <thead class="table-custom fs-5 fs-md-5 fs-lg-4">
                        <tr>
                            <th>Username</th>
                            <th class="d-none d-md-table-cell">First Name</th>
                            <th class="d-none d-md-table-cell">Last Name</th>
                            <th class="d-none d-lg-table-cell">City</th>
                            <th class="d-none d-lg-table-cell">State</th>
                            <th class="text-center">View</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <?php if ($user->getUserTypeId() == 3) : ?>
                                <tr class="fs-5 fs-md-5 fs-lg-4 custom-border-outset">
                                    <td><?php echo htmlspecialchars($user->getUserName()); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($user->getLastName()); ?></td>
                                    <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($user->getCity()); ?></td>
                                    <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($user->getState()); ?></td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">

                                            <form action="user_manager/index.php" method="POST" class="w-100">
                                                <input type="hidden" name="action" value="view_user">
                                                <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                                <button class="btn btn-lg bg-custom-black text-custom-white custom-border-outset w-100">View</button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>  
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>