<?php require_once ('../view/user_header.php'); ?>


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Users</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>City</th>
                            <th>State</th>
                            <th>zip</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <?php if ($user->getUserTypeId() == 3) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->getUserName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getLastName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getCity()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getState()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getZip()); ?></td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <form action="user_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="view_user">
                                                <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                                <button class="btn btn-sm btn-primary">View</button>
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