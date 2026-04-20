<?php require_once ('../view/request_header.php'); ?>

<h1 class="mt-2 text-center">Make A New Request</h1>

<div class="container mt-4">

    <p class="fs-4 text-center">
        Note: If you want to upload more than 1 image you must select multiple images together.
    </p>

    <div class="card custom-border-outset mb-4">
        <div class="card-header fs-4 bg-custom-blue text-custom-white">
            Create a New Request
        </div>
        <div class="card-body bg-custom-light-yellow">
            <form action="request_manager/index.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="action" value="create_request">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">

                <!---------- Title / Headline ---------->
                <div class="mb-3">
                    <label for="title" class="form-label fs-4">Title / Headline</label>
                    <input type="text" class="form-control form-control-lg border-2 border-black" id="title" name="title" placeholder="Title / Headline" required>
                </div>

                <!----------- Description ------------->
                <div class="mb-3">
                    <label for="body" class="form-label fs-4">Description</label>
                    <textarea class="form-control form-control-lg border-2 border-black" id="body" name="body" rows="6" placeholder="Enter a description or explanation" required></textarea>
                </div>

                <!---------------- Upload Images ----------->
                <div class="mb-3">
                    <label for="images" class="form-label fs-4">Upload Images</label>
                    <input class="form-control form-control-lg border-2 border-black" type="file" id="images" name="images[]" accept="image/*" multiple>
                </div>

                <!----------------- Submit Button ------------->
                <div class="mb-3 mt-5">
                    <button type="submit" class="btn btn-lg bg-custom-black text-custom-white custom-border-outset fs-4 w-100">Create Request</button>
                </div>

            </form>
        </div>
    </div>

</div>

<?php require_once ('../view/footer.php'); ?>