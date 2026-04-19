<?php require_once ('../view/user_header.php'); ?>

<div class="container-fluid mt-4 w-100">
    <div class="card custom-border-outset">
        <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
            <h3 class="mb-0">Users</h3>
        </div>
        <!-------------------------- Users Table --------------------->
        <div class="card-body bg-custom-blue">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle custom-border-outset">
                    <thead class="table-custom fs-4">
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>City</th>
                            <th>State</th>
                            <th class="text-center">View</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <?php if ($user->getUserTypeId() == 3) : ?>
                                <tr class="fs-4 custom-border-outset">
                                    <td><?php echo htmlspecialchars($user->getUserName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getLastName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getCity()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getState()); ?></td>

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