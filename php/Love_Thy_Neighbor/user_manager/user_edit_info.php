<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?> 

<div class="container my-4">

    <!-- Edit User -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit User</h4>
        </div>

        <div class="card-body">
            <form action="user_manager/index.php" method="post">
                <input type="hidden" name="action" value="update_user">

                <?php if ($user->getUserTypeId() != 3){ ?>
                    <div class="mb-3">
                        <label class="form-label">User ID</label>
                        <input class="form-control" name="user_id"
                               value="<?= htmlspecialchars($user->getID()); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Type ID</label>
                        <input class="form-control" name="user_type_id"
                               value="<?= htmlspecialchars($user->getUserTypeId()); ?>">
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->getID()); ?>">
                    <input type="hidden" name="user_type_id" value="<?= htmlspecialchars($user->getUserTypeId()); ?>">
                <?php } ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input class="form-control" name="first_name"
                               value="<?= htmlspecialchars($user->getFirstName()); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input class="form-control" name="last_name"
                               value="<?= htmlspecialchars($user->getLastName()); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input class="form-control" name="city"
                               value="<?= htmlspecialchars($user->getCity()); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input class="form-control" name="state"
                               value="<?= htmlspecialchars($user->getState()); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Zip</label>
                        <input class="form-control" name="zip"
                               value="<?= htmlspecialchars($user->getZip()); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" name="email"
                           value="<?= htmlspecialchars($user->getEmail()); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input class="form-control" name="phone"
                           value="<?= htmlspecialchars($user->getPhone()); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control" name="user_name"
                           value="<?= htmlspecialchars($user->getUserName()); ?>">
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Change Password -->
    <div class="card">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Change Password</h4>
        </div>

        <div class="card-body">
            <form action="user_manager/index.php" method="post">
                <input type="hidden" name="action" value="change_password">

                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-control" name="current_password">
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" name="new_password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Re-Enter New Password</label>
                    <input type="password" class="form-control" name="new_password_confirmed">
                </div>

                <button type="submit" class="btn btn-danger w-100">
                    Change Password
                </button>
            </form>
        </div>
    </div>

</div>

<?php require_once '../view/footer.php'; ?>