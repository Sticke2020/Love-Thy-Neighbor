
<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<?php  
/** @var Business $business */  // <-- docblock to tell view $business is a Business object
?> 

<div class="container my-4">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <!---------------- USER INFO ----------------->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit User Info</h4>
                </div>

                <div class="card-body">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="update_user">

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1){ ?>
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

            <!------------------ BUSINESS INFO ---------------->
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Edit Business Info</h4>
                </div>

                <div class="card-body">
                    <form action="business_manager/index.php" method="post">
                        <input type="hidden" name="action" value="update_business">
                        <input type="hidden" name="business_id" value="<?= $business->getId(); ?>">

                        <div class="mb-3">
                            <label class="form-label">Business Id</label>
                            <input class="form-control" 
                                   value="<?= htmlspecialchars($business->getId()); ?>" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Business Name</label>
                            <input class="form-control" name="business_name"
                                   value="<?= htmlspecialchars($business->getName()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input class="form-control" name="business_phone"
                                   value="<?= htmlspecialchars($business->getPhone()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input class="form-control" name="business_address"
                                   value="<?= htmlspecialchars($business->getAddress()); ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input class="form-control" name="business_city"
                                       value="<?= htmlspecialchars($business->getCity()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input class="form-control" name="business_state"
                                       value="<?= htmlspecialchars($business->getState()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zip</label>
                                <input class="form-control" name="business_zip"
                                       value="<?= htmlspecialchars($business->getZip()); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" name="business_description"><?= htmlspecialchars($business->getDescription()); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Verification Code</label>
                            <input class="form-control" name="business_code"
                                   value="<?= htmlspecialchars($business->getVerificationCode()); ?>">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-------------------- Registered Business Users -------------------->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Registered Employees</h4>
                </div>

                <div class="card-body">
                    <?php foreach ($employees as $employee) : ?>
                    <form action="business_manager/index.php" method="post">
                        <input type="hidden" name="action" value="remove_employee">
                        <input type="hidden" name="employee_id" value="<?php echo $employee->getUserId() ?>">
                        <input type="hidden" name="business_id" value="<?php echo $employee->getBusinessId() ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="employee_name"
                                       value="<?= htmlspecialchars($employee->getFullName()); ?>">
                            </div>

                            <button type="submit" class="btn btn-lg bg-custom-red text-custom-white w-100">
                                Remove As Employee
                            </button>
                        </div>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
         
            <!---------------------- PASSWORD -------------------->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Change Password</h4>
                </div>

                <div class="card-body">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="change_password">
                        <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">

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

            <!---------------------- DELETE ACCOUNT --------------------->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete Your Account</h4>
                </div>

                <div class="card-body">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="delete_account">
                        <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">

                        <div class="mb-3">
                            <label class="form-label">Enter Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>