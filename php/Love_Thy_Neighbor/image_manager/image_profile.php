<?php require_once ('../view/user_header.php'); ?>

<h1 class="mt-2 text-center">Choose A New Profile Image</h1>



<div class="container d-flex justify-content-center mt-4">

    <div class="card border-info mb-4 text-center w-100" style="max-width: 800px;">
        <div class="card-header fs-4">
            Upload Profile Image
        </div>
        <div class="card-body">

            <form action="image_manager/index.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="action" value="upload_profile_image">
                <input type="hidden" name="user_id" value="<?php echo $userId ?>">

                <!-- File input -->
                <div class="mb-3">
                    <label for="profileImage" class="form-label fs-4">Select Image</label>
                    <input class="form-control fs-4" type="file" id="profileImage" name="image" accept="image/*" required>
                </div>

                <!-- Submit button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-info w-100 fs-4">Submit</button>
                </div>

            </form>

        </div>
    </div>

</div>


<?php require_once ('../view/footer.php'); ?>