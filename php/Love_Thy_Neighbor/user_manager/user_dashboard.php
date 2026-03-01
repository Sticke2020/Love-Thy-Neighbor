
<?php require_once ('../view/user_header.php'); ?>



<aside class="grid_container">
    <div class="profile_pic_wrapper">
        <?php if ($profilePic == null) { ?>
            <img src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo $user->getUserName()?>">
        <?php } else { ?>
            <img src="<?php echo $profilePic->getFileUrl(); ?>">
        <?php } ?>
    </div> 

    <div class="user_info">
        <h1><?php echo $user->getUserName()?></h1>
        <h1>business name</h1>
    </div>
</aside>

    <form action="image_manager/index.php" method="POST">
        <input type="hidden" name="action" value="add_profile_image" />
        <input type="submit" value="Change Profile Image" />
    </form>

<section>
    <fieldset>
    <legend><?php echo $user->getUserName() . "'s " . 'Requests' ?></legend>
    <?php foreach ($requests as $request) :?>
        <div>
            <h2><?php echo $request->getTitle(); ?></h2>
            <div>
                <?php foreach ($request->getImages() as $image): ?>
                    <img src="<?php echo $image->getFileUrl(); ?>" width="200">
                <?php endforeach; ?>
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