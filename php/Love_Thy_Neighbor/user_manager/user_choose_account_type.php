<?php 
 require_once '../view/header.php'; 
?> 

<div class="container my-5 p-0">

    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card custom-border-outset shadow">
                <div class="card-header bg-custom-blue text-custom-white text-center">
                    <h3 class="mb-0">Choose Account Type</h3>
                </div>

                <div class="card-body bg-custom-light-yellow">

                    <p class="fs-3">
                        Select the type of account you want to create.
                    </p>
                    <!------------ Account Type Choices ------------>
                    <ul class="fs-4 m-4">
                        <li><strong>Personal Account:</strong> For individual users</li>
                        <li><strong>Employee Account:</strong> For users linked to an existing business</li>
                        <li><strong>Business Account:</strong> For business owners or representatives</li>
                    </ul>

                    <form action="user_manager/index.php" method="post">
                        <input type="hidden" name="action" value="register_account">

                        <!--------------- Radio Button Options ------------>
                        <div class="list-group mb-4">

                            <label class="list-group-item d-flex align-items-center fs-4 bg-custom-light-yellow">
                                <input class="form-check-input me-4"
                                       type="radio"
                                       name="account_type"
                                       value="PERSONAL"
                                       checked>
                                <div>
                                    <strong>Personal Account</strong><br>
                                    <small>For individual use</small>
                                </div>
                            </label>

                            <label class="list-group-item d-flex align-items-center fs-4 bg-custom-light-yellow">
                                <input class="form-check-input me-4"
                                       type="radio"
                                       name="account_type"
                                       value="EMPLOYEE">
                                <div>
                                    <strong>Employee Account</strong><br>
                                    <small>Join an existing business</small>
                                </div>
                            </label>

                            <label class="list-group-item d-flex align-items-center fs-4 bg-custom-light-yellow">
                                <input class="form-check-input me-4"
                                       type="radio"
                                       name="account_type"
                                       value="BUSINESS">
                                <div>
                                    <strong>Business Account</strong><br>
                                    <small>Create and manage a business</small>
                                </div>
                            </label>

                        </div>

                        <button type="submit" class="btn btn-lg bg-custom-black custom-border-outset text-custom-white w-100 fs-4">
                            Next
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
<?php require_once '../view/footer.php'; ?>