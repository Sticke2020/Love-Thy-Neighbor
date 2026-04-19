<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<h1 class="mt-3 text-center">Edit Your Request</h1>

<div class="container mt-4">

    <p class="fs-3 text-center">
        <strong>Note:</strong> If you want to upload more than 1 image you must select multiple images together.
    </p>

    <div class="card custom-border-outset mb-4">
        <div class="card-header fs-4 bg-custom-blue text-custom-white">
            Edit Request
        </div>

        <div class="card-body bg-custom-light-yellow">
            <form action="request_manager/index.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="action" value="update_request">
                <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">

                <!-------------- Title / Headline --------->
                <div class="mb-3">
                    <label for="title" class="form-label fs-4">Title / Headline</label>
                    <input type="text" class="form-control form-control-lg border-2 border-black" id="title" name="title" 
                           value="<?php echo htmlspecialchars($request->getTitle()); ?>" required>
                </div>

                <!---------------- Description ------------->
                <div class="mb-3">
                    <label for="body" class="form-label fs-4">Description</label>
                    <textarea class="form-control form-control-lg border-2 border-black" id="body" name="body"
                             rows="6" required><?php echo htmlspecialchars($request->getBody()); ?></textarea>
                </div>

                <!-------------- Upload New Images ---------->
                <div class="mb-3">
                    <label for="images" class="form-label fs-4">Upload New Images</label>
                    <input class="form-control form-control-lg border-2 border-black" type="file" id="images" 
                            name="images[]" accept="image/*" multiple>
                </div>

                <!------------- Current Images --------------->
                <?php if (!empty($request->getImages())): ?>
                    <h5 class="fs-4">Current Images</h5>

                    <div class="row mb-3">
                        <?php foreach ($request->getImages() as $image): ?>
                            <div class="col-md-3 mb-3 text-center">
                                <img src="<?php echo $image->getFileUrl(); ?>" class="img-fluid rounded mb-2">

                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <input class="form-check-input me-1 fs-4 border-2 border-black" type="checkbox" name="delete_images[]" 
                                           value="<?php echo $image->getId(); ?>" id="delete-<?php echo $image->getId(); ?>">
                                    <label class="form-check-label fs-4" for="delete-<?php echo $image->getId(); ?>">Delete</label>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!---------------- Submit Button ----------------->
                <div class="mb-3">
                    <button type="submit" class="mt-3 btn btn-lg bg-custom-black custom-border-outset text-custom-white w-100">Update Request</button>
                </div>

            </form>
        </div>
    </div>

</div>
<?php require_once ('../view/footer.php'); ?>