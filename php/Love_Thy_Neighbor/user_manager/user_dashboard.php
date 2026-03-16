
<?php require_once ('../view/user_header.php'); ?>



<div class="container-fluid px-0 mb-3">
    <div class="row align-items-start">

        <!--User Profile Image-->
        <div class="col-auto" style="max-width: 40%; max-height: 500px;" >

            <?php if ($profilePic == null) { ?>
                <img class="img-fluid" src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo $user->getUserName()?>">
            <?php } else { ?>
                <img class="img-fluid" src="<?php echo $profilePic->getFileUrl(); ?>">
            <?php } ?>

            <form action="image_manager/index.php" method="POST">
                <input type="hidden" name="action" value="add_profile_image" />
                <input class="btn bg-custom-white w-100 mt-2 fs-4" type="submit" value="Change Profile Image" />
            </form>

        </div> 

        <!--User Profile Data such as Name and Business-->
        <div class="col">
            <h1 class="mt-1"><?php echo $user->getUserName()?></h1>
            <?php if ($business == null) { ?>
            <?php } else { ?>
                <?php if (isset($_SESSION['businessUser']) && $_SESSION['businessUser']->getIsAdmin()) { ?>
                    <h1 class="mt-2">Representative of <?php echo $business->getName()?></h1>
                <?php } else { ?>
                    <h1 class="mt-2">Employee of <?php echo $business->getName()?></h1>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>



<div class="container-fluid mt-3 px-0">
    <div class="row">
        <div class="col" style="max-width: 50%;">

            <!-- User Requests Card -->
            <div class="card">
                <div class="card-header text-center fs-4 bg-custom-black text-custom-white">
                    <?php echo $user->getUserName() . "'s Requests"; ?>
                </div>
                <div class="card-body bg-custom-blue">

                    <?php if (empty($requests)) : ?>
                        <p class="text-muted text-custom-white fs-4">No requests found.</p>
                    <?php else : ?>
                        <?php foreach ($requests as $request) : ?>
                            <div class="card mb-3 bg-custom-gold">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $request->getTitle(); ?></h5>

                                    <?php if (!empty($request->getImages())) : ?>
                                        <div class="mb-2">
                                            <?php foreach ($request->getImages() as $image): ?>
                                                <img src="<?php echo $image->getFileUrl(); ?>" width="200" class="me-2 mb-2 img-thumbnail">
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <p class="card-text"><?php echo $request->getBody(); ?></p>

                                    <p><strong>Request Status:</strong>
                                        <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?>
                                    </p>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2 flex-wrap">
                                        <form action="request_manager/index.php" method="POST">
                                            <input type="hidden" name="action" value="delete_request">
                                            <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">
                                            <button class="btn btn-danger btn-sm" type="submit">Delete Request</button>
                                        </form>

                                        <form action="request_manager/index.php" method="POST">
                                            <input type="hidden" name="action" value="mark_request_fulfilled">
                                            <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">
                                            <button class="btn btn-success btn-sm" type="submit">Mark Fulfilled</button>
                                        </form>

                                        <form action="request_manager/index.php" method="POST">
                                            <input type="hidden" name="action" value="edit_request">
                                            <input type="hidden" name="request_id" value="<?php echo $request->getId(); ?>">
                                            <button class="btn btn-primary btn-sm" type="submit">Edit Request</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col">
            <!--User Feedback-->
            <div class="card">
                <div class="card-header text-center fs-4 bg-custom-black text-custom-white">
                    <?php echo $user->getUserName() . "'s Feedback"; ?>
                </div>
                <div class="card-body bg-custom-blue">
                    <?php if (empty($feedback)) : ?>
                        <p class="text-muted text-custom-white fs-4">No Feedback found.</p>
                    <?php else : ?>
                        <?php foreach ($feedback as $comment) : ?>
                            <div class="card mb-3 bg-custom-gold">
                                <div class="card-body">
                                    <h5 class="card-title fs-4">From: <?php echo $comment->getSender(); ?></h5>
                                    <img class="img-fluid" style="max-width: 20%;" src="<?php echo $comment->getSenderImage(); ?>">
                                    <p class="card-text fs-4"><?php echo $comment->getComment(); ?></p>
                                    <p class="fs-5"><strong>Date Created:</strong>
                                        <?php echo $comment->getDateCreated(); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</div>



<?php require_once ('../view/footer.php'); ?>