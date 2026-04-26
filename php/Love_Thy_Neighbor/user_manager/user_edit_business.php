
<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<?php  
/** @var Business $business */  // <-- docblock to tell view $business is a Business object
?> 

<h1 class="mt-3 text-center">Edit Your Information</h1>

<div class="container my-4 p-0">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <!---------------- USER INFO ----------------->
            <div class="card mb-5 custom-border-outset">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0 fs-4">Edit User Info</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="update_user">

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1){ ?>
                            <div class="mb-3">
                                <label class="form-label fs-4">User ID</label>
                                <input class="form-control form-control-lg border-2 border-black" name="user_id"
                                       value="<?= htmlspecialchars($user->getID()); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fs-4">User Type ID</label>
                                <input class="form-control form-control-lg border-2 border-black" name="user_type_id"
                                       value="<?= htmlspecialchars($user->getUserTypeId()); ?>">
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->getID()); ?>">
                            <input type="hidden" name="user_type_id" value="<?= htmlspecialchars($user->getUserTypeId()); ?>">
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-4">First Name</label>
                                <input class="form-control form-control-lg border-2 border-black" name="first_name"
                                       value="<?= htmlspecialchars($user->getFirstName()); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-4">Last Name</label>
                                <input class="form-control form-control-lg border-2 border-black" name="last_name"
                                       value="<?= htmlspecialchars($user->getLastName()); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">City</label>
                                <input class="form-control form-control-lg border-2 border-black" name="city"
                                       value="<?= htmlspecialchars($user->getCity()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">State</label>
                                <input class="form-control form-control-lg border-2 border-black" name="state"
                                       value="<?= htmlspecialchars($user->getState()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">Zip</label>
                                <input class="form-control form-control-lg border-2 border-black" name="zip"
                                       value="<?= htmlspecialchars($user->getZip()); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Email</label>
                            <input class="form-control form-control-lg border-2 border-black" name="email"
                                   value="<?= htmlspecialchars($user->getEmail()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Phone</label>
                            <input class="form-control form-control-lg border-2 border-black" name="phone"
                                   value="<?= htmlspecialchars($user->getPhone()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Username</label>
                            <input class="form-control form-control-lg border-2 border-black" name="user_name"
                                   value="<?= htmlspecialchars($user->getUserName()); ?>">
                        </div>

                        <button type="submit" class="mt-3 btn btn-lg bg-custom-black custom-border-outset w-100 text-custom-white fs-4">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!------------------ BUSINESS INFO ---------------->
            <div class="card mb-5 custom-border-outset">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0 fs-4">Edit Business Info</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <form action="business_manager/index.php" method="post">
                        <input type="hidden" name="action" value="update_business">
                        <input type="hidden" name="business_id" value="<?= htmlspecialchars($business->getId()); ?>">

                        <div class="mb-3">
                            <label class="form-label fs-4">Business Id</label>
                            <input class="form-control form-control-lg border-2 border-black" 
                                   value="<?= htmlspecialchars($business->getId()); ?>" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Business Name</label>
                            <input class="form-control form-control-lg border-2 border-black" name="business_name"
                                   value="<?= htmlspecialchars($business->getName()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Phone</label>
                            <input class="form-control form-control-lg border-2 border-black" name="business_phone"
                                   value="<?= htmlspecialchars($business->getPhone()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Address</label>
                            <input class="form-control form-control-lg border-2 border-black" name="business_address"
                                   value="<?= htmlspecialchars($business->getAddress()); ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">City</label>
                                <input class="form-control form-control-lg border-2 border-black" name="business_city"
                                       value="<?= htmlspecialchars($business->getCity()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">State</label>
                                <input class="form-control form-control-lg border-2 border-black" name="business_state"
                                       value="<?= htmlspecialchars($business->getState()); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fs-4">Zip</label>
                                <input class="form-control form-control-lg border-2 border-black" name="business_zip"
                                       value="<?= htmlspecialchars($business->getZip()); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Description</label>
                            <textarea class="form-control form-control-lg border-2 border-black" rows="4" name="business_description"><?= htmlspecialchars($business->getDescription()); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Verification Code</label>
                            <input class="form-control form-control-lg border-2 border-black" name="business_code"
                                   value="<?= htmlspecialchars($business->getVerificationCode()); ?>">
                        </div>

                        <button type="submit" class="mt-3 btn btn-lg bg-custom-black custom-border-outset w-100 text-custom-white fs-4">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-------------------- Registered Business Users -------------------->
            <div class="card mb-5 custom-border-outset">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0 fs-4">Edit Registered Employees</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <?php foreach ($employees as $employee) : ?>
                    <form action="business_manager/index.php" method="post" class="mb-4">
                        <input type="hidden" name="action" value="remove_employee">
                        <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee->getUserId()); ?>">
                        <input type="hidden" name="business_id" value="<?php echo htmlspecialchars($employee->getBusinessId()); ?>">

                        <div>
                            <div class="mb-3">
                                <label class="form-label fs-4">Name</label>
                                <input class="form-control form-control-lg border-2 border-black" name="employee_name"
                                       value="<?= htmlspecialchars($employee->getFullName()); ?>">
                            </div>

                            <button type="submit" class="mt-3 btn btn-lg bg-custom-red custom-border-outset w-100 text-custom-white fs-4">
                                Remove As Employee
                            </button>
                        </div>
                    </form>
                    <hr class="my-5 border-4 border-black">
                    <?php endforeach; ?>
                </div>
            </div>
         
            <!---------------------- PASSWORD -------------------->
            <div class="card mb-5 custom-border-outset">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0 fs-4">Change Password</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="change_password">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">

                        <div class="mb-3">
                            <label class="form-label fs-4">Current Password</label>
                            <input type="password" class="form-control form-control-lg border-2 border-black" name="current_password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">New Password</label>
                            <input type="password" class="form-control form-control-lg border-2 border-black" name="new_password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-4">Re-Enter New Password</label>
                            <input type="password" class="form-control form-control-lg border-2 border-black" name="new_password_confirmed">
                        </div>

                        <button type="submit" class="mt-3 btn btn-lg bg-custom-black custom-border-outset w-100 text-custom-white fs-4">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>

            <!---------------------- DELETE ACCOUNT --------------------->
            <div class="card custom-border-outset">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0 fs-4">Delete Your Account</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="delete_account">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">

                        <div class="mb-3">
                            <label class="form-label fs-4">Enter Password</label>
                            <input type="password" class="form-control form-control-lg border-2 border-black" name="password">
                        </div>

                        <button type="submit" class="mt-3 btn btn-lg bg-custom-red custom-border-outset w-100 text-custom-white fs-4">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>