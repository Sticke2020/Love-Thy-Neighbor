<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<h1 class="mt-4 text-center">Choose A New Profile Image</h1>

<h3 class="mt-4 text-center">Acceptable Image Types = ( .jpg .jpeg .png .gif .avif )</h3>

<div class="container d-flex justify-content-center mt-4">

    <div class="card custom-border-outset mb-4 text-center w-100">
        <div class="card-header fs-4 bg-custom-blue text-custom-white">Upload Profile Image</div>
        <div class="card-body">
                            <!--------- enctype="multipart/form-data" for uploading files ------------------->
            <form action="image_manager/index.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="action" value="upload_profile_image">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">

                <!-------------------- File input ----------------->
                <div class="mb-5">
                    <label for="profileImage" class="form-label fs-4 mb-4">Select Image</label>
                    <input class="form-control form-comtrol-lg custom-border-outset fs-4" type="file" id="profileImage" name="image" accept="image/*" required>
                </div>

                <!------------------- Submit button --------------------->
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg text-custom-white custom-border-outset bg-custom-black w-100 fs-4">Submit</button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once ('../view/footer.php'); ?>