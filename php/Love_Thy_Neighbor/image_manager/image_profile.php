<?php require_once ('../view/user_header.php'); ?>

<h1>Choose A New Profile Image</h1>

<body>
<p></p>
    <fieldset>
        <form action="image_manager/index.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload_profile_image">
            <input type="hidden" name="user_id" value="<?php echo $userId ?>">
            <label>Upload Image</label>
            <input type="file" name="image" accept="image/*">
            <input  type="submit" value="Submit">
        </form>
    </fieldset>
</body>

<?php require_once ('../view/footer.php'); ?>