
<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>


<div class="container-fluid px-0 mb-3">
    <div class="row align-items-start gy-3">

        <!------User Profile Image--------->
        <div class="col-12 col-md-4">

            <?php if ($profilePic == null) { ?>
                <img class="img-fluid custom-border-outset" src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo htmlspecialchars(urlencode($user->getUserName())); ?>">
            <?php } else { ?>
                <img class="img-fluid custom-border-outset" src="<?php echo htmlspecialchars($profilePic->getFileUrl()); ?>">
            <?php } ?>
            <!--This form is to keep uniformity with the dashboard layout since the image size is related
                to the button size, there may be a better way to fix this later, the image doesnt display 
                properly without this -->
            <form >
                <input type="hidden" />
                <input class="btn bg-custom-gold w-100 mt-2 fs-4" style="border: none" value="                    " disabled/>
            </form>

        </div> 

        <!--User Profile Data such as Name and Business-->
        <div class="col-12 col-md-5">
            <h1 class="mt-1"><?php echo htmlspecialchars($user->getUserName()); ?></h1>
            <?php if ($business == null) { ?>
            <?php } else { ?>
                <?php if ($businessUser->getIsAdmin() == 1) { ?>
                    <h2 class="mt-3">Representative of <?php echo htmlspecialchars($business->getName()); ?></h2>
                <?php } else { ?>
                    <h1 class="mt-3">Employee of <?php echo htmlspecialchars($business->getName()); ?></h1>
                <?php } ?>
            <?php } ?>
            <h3 class="mt-3">City: <?php echo htmlspecialchars($user->getCity()); ?></h3>
            <h3 class="mt-2">State: <?php echo htmlspecialchars($user->getState()); ?></h3>
            <h3 class="mt-2">Zip: <?php echo htmlspecialchars($user->getZip()); ?></h3>
        </div>

        <!----------------Messages Button------------->
        <div class="col-12 col-md-3">
            <form action="message_manager/index.php" method="POST" class="text-md-end mt-3">
                <input type="hidden" name="action" value="message_user">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                <button class="fs-4 btn bg-custom-black text-custom-white btn-lg custom-border-outset w-100" type="submit">Message <?php echo htmlspecialchars($user->getUserName()); ?></button> 
            </form>
        </div>

    </div>
</div>

<div class="container-fluid mt-3 px-0">
    <div class="row">
        <div class="col-12 col-lg-6">

            <!----------------- User Requests Card ------------->
            <div class="card custom-border-outset">
                <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
                    <?php echo htmlspecialchars($user->getUserName()) . "'s Requests"; ?>
                </div>
                <div class="card-body bg-custom-blue">

                    <?php if (empty($requests)) : ?>
                        <p class="text-muted text-custom-white fs-4">No requests found.</p>
                    <?php else : ?>
                        <?php foreach ($requests as $request) : ?>
                            <div class="card mb-3 bg-custom-gold border custom-border-inset">
                                <div class="card-body">
                                    <h5 class="card-title fs-4"><strong><?php echo htmlspecialchars($request->getTitle()); ?></strong></h5>

                                    <?php if (!empty($request->getImages())) : ?>
                                        <div class="mb-2">
                                            <?php foreach ($request->getImages() as $image): ?>
                                                <img src="<?php echo htmlspecialchars($image->getFileUrl()); ?>" style="max-width: 200px;" class="me-2 mb-2 img-thumbnail">
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <p class="card-text fs-4"><?php echo htmlspecialchars($request->getBody()); ?></p>

                                    <p class="fs-5"><strong>Request Status:</strong>
                                        <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?>
                                    </p>

                                    <!----------- Buttons --------------->
                                    <div class="d-flex gap-2 flex-wrap">
                                        <form action="request_manager/index.php" method="POST">
                                            <input type="hidden" name="action" value="fulfill_request">
                                            <input type="hidden" name="request_title" value="<?php echo htmlspecialchars($request->getTitle()); ?>">
                                            <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($userId); ?>"> 
                                            <button class="btn bg-custom-black text-custom-white btn-lg custom-border-outset fs-4" type="submit">Fulfill Request</button>
                                        </form>
                                        
                                        <?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) : ?>
                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="delete_request">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="btn bg-custom-red text-custom-white btn-lg custom-border-outset fs-4" type="submit">Delete Request</button>
                                            </form>

                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="mark_request_fulfilled">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="btn bg-custom-blue text-custom-white btn-lg custom-border-outset fs-4" type="submit">Mark Fulfilled</button>
                                            </form>

                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="edit_request">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="btn bg-custom-grey text-custom-white btn-lg custom-border-outset fs-4" type="submit">Edit Request</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <!-----------------User Feedback------------------>
            <div class="card custom-border-outset">
                <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
                    <?php echo htmlspecialchars($user->getUserName()) . "'s Feedback"; ?>
                </div>
                <div class="card-header text-center fs-4 bg-custom-blue border-0">
                    <form action="feedback_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="leave_feedback">
                        <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($_SESSION['userId']); ?>">
                        <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($userId); ?>">
                        <input type="submit" class="btn btn-lg bg-custom-black text-custom-white w-100 mt-2 fs-4 custom-border-outset" value="Leave Feedback">
                    </form>
                </div>
                <div class="card-body bg-custom-blue">
                    <?php if (empty($feedback)) : ?>
                        <p class="text-muted text-custom-white fs-4">No Feedback found.</p>
                    <?php else : ?>
                        <?php foreach ($feedback as $comment) : ?>
                            <div class="card mb-3 bg-custom-gold border custom-border-inset">
                                <div class="card-body">
                                    <h5 class="card-title fs-4"><strong>From:</strong> <?php echo htmlspecialchars($comment->getSender()); ?></h5>
                                    
                                    <form action="user_manager/index.php" method="POST" class="d-inline-block align-top">
                                        <input type="hidden" name="action" value="view_user">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($comment->getSenderId()); ?>">

                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img src="<?php echo htmlspecialchars($comment->getSenderImage()); ?>"
                                                class="me-2 mb-2 img-thumbnail"
                                                style="width:100px; height:100px; object-fit:cover;">
                                        </button>
                                    </form>

                                    <p class="card-text fs-4"><?php echo htmlspecialchars($comment->getComment()); ?></p>
                                    <p class="fs-5"><strong>Date Created:</strong>
                                        <?php echo htmlspecialchars($comment->getDateCreated()); ?>
                                    </p>
                                    <?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) : ?>
                                        <form action="feedback_manager/index.php" method="POST">
                                            <input type="hidden" name="action" value="delete_feedback">
                                            <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($comment->getId()); ?>">
                                            <button type="submit" class="btn bg-custom-red text-custom-white btn-lg custom-border-outset fs-4">Delete Feedback</button>
                                        </form>
                                    <?php endif; ?>
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