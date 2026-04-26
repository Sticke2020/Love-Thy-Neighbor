<?php 
 require_once '../view/header.php'; 
?> 

<div class="container my-4 p-0">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card custom-border-outset shadow">
                <div class="card-header bg-custom-blue text-custom-white text-center">
                    <h3 class="mb-0">Register User</h3>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <p class="fs-3">All fields are required</p>

                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="add_user">

                        <!--------------- User Info ------------->
                        <div class="row">
                            <div class="col-md-6 mb-3 fs-4">
                                <label class="form-label text-black">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-lg border-2 border-black" required>
                            </div>

                            <div class="col-md-6 mb-3 fs-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-lg border-2 border-black" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control form-control-lg border-2 border-black" required>
                            </div>

                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control form-control-lg border-2 border-black" required>
                            </div>

                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="zip" class="form-control form-control-lg border-2 border-black" required>
                            </div>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Username</label>
                            <input type="text" name="user_name" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <button type="submit" class="btn btn-lg bg-custom-black custom-border-outset text-custom-white w-100 fs-4 mt-5">
                            Register
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<?php require_once '../view/footer.php'; ?>