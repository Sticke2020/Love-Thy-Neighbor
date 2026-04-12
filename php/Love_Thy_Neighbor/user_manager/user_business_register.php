<?php 
 require_once '../view/header.php'; 
?> 

<div class="container my-4">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0">Register Business</h4>
                </div>

                <div class="card-body bg-custom-light-yellow">
                    <p class="fs-3">All fields are required.</p>
                    <p class="fs-3">A user account will be created and tied to your business.</p>

                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="add_user_business">

                        <!------------- USER INFO ------------>
                        <h5 class="mt-3 fs-3 mt-5">User Information</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3 fs-4">
                                <label class="form-label">First Name</label>
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

                        <!--------------- BUSINESS INFO ---------->
                        <h5 class="mt-4 fs-3 mt-5">Business Information</h5>
                        <hr>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Business Name</label>
                            <input type="text" name="business_name" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Business Phone</label>
                            <input type="text" name="business_phone" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Address</label>
                            <input type="text" name="business_address" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">City</label>
                                <input type="text" name="business_city" class="form-control form-control-lg border-2 border-black" required>
                            </div>

                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">State</label>
                                <input type="text" name="business_state" class="form-control form-control-lg border-2 border-black" required>
                            </div>

                            <div class="col-md-4 mb-3 fs-4">
                                <label class="form-label">Zip</label>
                                <input type="text" name="business_zip" class="form-control form-control-lg border-2 border-black" required>
                            </div>
                        </div>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Description</label>
                            <textarea name="business_description" class="form-control form-control-lg border-2 border-black" rows="3" required></textarea>
                        </div>

                        <!------------------ VERIFICATION ---------------->
                        <h5 class="mt-4 fs-3 mt-5">Verification Setup</h5>
                        <hr>

                        <p class="fs-3">
                            Create a verification code for your employees. They will need this code and your Business ID to register.
                        </p>

                        <div class="mb-3 fs-4">
                            <label class="form-label">Verification Code</label>
                            <input type="text" name="business_code" class="form-control form-control-lg border-2 border-black" required>
                        </div>

                        <button type="submit" class="btn btn-lg bg-custom-black text-custom-white fs-4 w-100 mt-5">
                            Register Business
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<?php require_once '../view/footer.php'; ?>