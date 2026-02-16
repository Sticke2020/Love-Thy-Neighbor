
<?php require_once ('../view/user_header.php'); ?>



<aside class="grid_container">
    <div class="profile_pic_wrapper">
        <img src="Images/eye_001_.png" alt="This is a test image">
    </div> 

    <div class="user_info">
        <h1><?php echo $user->getUserName()?></h1>
        <h1>business name</h1>
    </div>
</aside>

    <form action="upload_manager/index.php" method="POST">
        <input type="hidden" value="add_profile_image" />
        <input type="submit" value="Change Profile Image" />
    </form>

<section>
    <fieldset>
    <legend><?php echo $user->getUserName() . "'s " . 'Requests' ?></legend>
    <?php foreach ($requests as $request) :?>
        <div>
            <h2><?php echo $request->getTitle(); ?></h2>
            <div>
                <img src="<?php echo $request->getFileUrl(); ?>" >
            </div>
            <div>
                <p><?php echo $request->getBody(); ?></p>
            </div>
            <div>
                <h3>Request Status = <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?></h3>
            </div>
            <form action="request_manager/index.php" method="POST">
                <input type="hidden" name="action" value="delete_request">
                <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">
                <input type="submit" value="Delete Request">
            </form>
            <form action="request_manager/index.php" method="POST">
                <input type="hidden" name="action" value="mark_request_fulfilled">
                <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">
                <input type="submit" value="Request Has Been Fulfilled">
            </form>
        </div>
    <?php endforeach; ?>
    </fieldset>
</section>


<?php require_once ('../view/footer.php'); ?>