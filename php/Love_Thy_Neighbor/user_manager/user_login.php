<?php require_once '../view/header.php'; ?>

<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-9">

            <div class="card shadow">
                <div class="card-header bg-custom-blue text-custom-white text-center">
                    <h4 class="mb-0">Please Log In</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">

                    <!------------ Error Message -------------->
                    <?php if (!empty($errorMessage)) { ?>
                        <div class="alert alert-danger text-center">
                            <?= $errorMessage ?>
                        </div>
                    <?php } ?>

                    <form method="POST" action="user_manager/index.php">
                        <input type="hidden" name="action" value="validate_login">

                        <div class="mb-3 fs-4">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control form-control-lg border-2 border-black"
                                   placeholder="Enter your email"
                                   required>
                        </div>

                        <div class="mb-4 fs-4">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg border-2 border-black"
                                   placeholder="Enter your password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-lg bg-custom-black text-custom-white w-100 fs-4 mt-5">
                            Login
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
<?php require_once '../view/footer.php'; ?>