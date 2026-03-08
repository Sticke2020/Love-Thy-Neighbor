<?php require_once ('../view/request_header.php'); ?>

<h1>Edit Your Request</h1>

<p>Note: If you want to upload more than 1 Image you must select multiple Images together</p>
<fieldset>
<form action="request_manager/index.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="action" value="update_request">
    <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">

    <div class="edit">
        <label>Title/Headline</label>
        <input type="text" name="title" value="<?php echo $request->getTitle(); ?>">
    </div>

    <div class="edit">
        <label>Description</label>
        <textarea name="body" rows="6" cols="50"><?php echo $request->getBody(); ?></textarea>
    </div>

    <div class="edit">
        <label>Upload New Images</label>
        <input type="file" name="images[]" accept="image/*" multiple>
    </div>

    <h3>Current Images</h3>

    <?php foreach ($request->getImages() as $image): ?>

        <div class="edit">
            <img src="<?php echo $image->getFileUrl(); ?>" width="200px"><br>

            <label>
                <input type="checkbox" name="delete_images[]" 
                       value="<?php echo $image->getId(); ?>">
                Delete Image
            </label>
        </div>

    <?php endforeach; ?>

    <div class="edit">
        <input type="submit" value="Update Request">
    </div>

</form>
</fieldset>
<?php require_once ('../view/footer.php'); ?>