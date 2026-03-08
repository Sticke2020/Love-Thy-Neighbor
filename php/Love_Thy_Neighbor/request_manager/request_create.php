<?php require_once ('../view/request_header.php'); ?>

<h1>Make A New Request</h1>


<p>Note: If you want to upload more than 1 Image you must select multiple Images together</p>
<fieldset>
    <form action="request_manager/index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create_request">
        <input type="hidden" name="user_id" value="<?php echo $userId ?>">
        <div class="edit">
            <label>Title/Headline</label>
            <input type="text" name="title" placeholder="Title / Headline">
        </div>
        <div class="edit">
            <label>Description</label>
            <textarea name="body" rows="6" cols="50" placeholder="Enter A description or Explanation"></textarea>
        </div>
        <div class="edit">
            <label>Upload Images</label>
            <input type="file" name="images[]" accept="image/*" multiple>
        </div>
        <div class="edit">
            <label></label>
            <input  type="submit" value="Create Request">
        </div>
    </form>
</fieldset>



<?php require_once ('../view/footer.php'); ?>