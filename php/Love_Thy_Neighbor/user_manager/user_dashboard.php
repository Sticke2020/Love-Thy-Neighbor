
<?php require_once ('../view/user_header.php'); ?>

<div class="container-fluid px-0 mb-4">
    <div class="row align-items-start gy-3">

        <!--------- User Profile Image ---------------------------------->
        <div class="col-12 col-md-4">
            <div class="d-inline-block">
                <?php if ($profilePic == null) { ?>
                    <img class="img-fluid custom-border-outset" src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo htmlspecialchars(urlencode($user->getUserName())); ?>">
                <?php } else { ?>
                    <img class="img-fluid custom-border-outset" src="<?php echo htmlspecialchars($profilePic->getFileUrl()); ?>">
                <?php } ?>

                <form action="image_manager/index.php" method="POST">
                    <input type="hidden" name="action" value="add_profile_image" />
                    <input class="btn btn-lg bg-custom-black text-custom-white w-100 mt-2 fs-4 custom-border-outset" type="submit" value="Change Profile Image" />
                </form>
            </div>
        </div> 

        <!------------ User Profile Data such as Name and Business ------>
        <div class="col-12 col-md-5">
            <h1 class="mt-1"><?php echo htmlspecialchars($user->getUserName()); ?></h1>

            <?php if ($business == null) { ?>
            <?php } else { ?>
                <?php if (isset($_SESSION['businessUser']) && $_SESSION['businessUser']->getIsAdmin()) { ?>
                    <h2 class="mt-3">Representative of <?php echo htmlspecialchars($business->getName()); ?></h2>
                <?php } else { ?>
                    <h2 class="mt-3">Employee of <?php echo htmlspecialchars($business->getName()); ?></h2>
                <?php } ?>
            <?php } ?>

            <h3 class="mt-3">City: <?php echo htmlspecialchars($user->getCity()); ?></h3>
            <h3 class="mt-2">State: <?php echo htmlspecialchars($user->getState()); ?></h3>
            <h3 class="mt-2">Zip: <?php echo htmlspecialchars($user->getZip()); ?></h3>
        </div>

        <!---------------------------- Messages Button ------------------>
        <?php if ($unreadMessages == true) { ?>
        <div class="col-12 col-md-3">
            <form action="message_manager/index.php" method="POST" class="text-md-end mt-3">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                <button class="btn text-custom-white btn-lg custom-border-outset fs-4"
                    id="inbox_button_blink" type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } else { ?>
        <div class="col-12 col-md-3">
            <form action="message_manager/index.php" method="POST" class="text-md-end mt-3">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                <button class="btn bg-custom-black text-custom-white btn-lg custom-border-outset fs-4"
                         type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } ?>
    </div>
</div>


<div class="container-fluid mt-3 px-0">
    <div class="row">
        <div class="col-12 col-lg-6">

            <!----------------------- User Requests Card ---------------->
            <div class="card custom-border-outset shadow">
                <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
                    <?php echo htmlspecialchars($user->getUserName()) . "'s Requests"; ?>
                </div>

                <div class="card-header text-center fs-4 bg-custom-blue border-0">
                    <form action="request_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="make_request">
                        <input type="submit" class="custom-border-outset btn btn-lg bg-custom-black text-custom-white w-100 mt-2 fs-4 " value="Create Request">
                    </form>
                </div>

                <div class="card-body bg-custom-blue">

                    <?php if (empty($requests)) : ?>
                        <p class="text-muted text-custom-white fs-4">No requests found.</p>
                    <?php else : ?>
                        <?php foreach ($requests as $request) : ?>
                            <?php if ($request->getRequestStatusTypeId() == 1) : ?> 

                                <!--------- Unfulfilled Requests --------------->
                                <div class="card mb-3 bg-custom-gold border custom-border-inset">
                                    <div class="card-body">
                                        <h5 class="card-title fs-4"><strong><?php echo htmlspecialchars($request->getTitle()); ?></strong></h5>

                                        <?php if (!empty($request->getImages())) : ?>
                                            <div class="mb-2">
                                                <?php foreach ($request->getImages() as $image): ?>
                                                    <img src="<?php echo htmlspecialchars($image->getFileUrl()); ?>" class="me-2 mb-2 img-thumbnail">
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <p class="card-text fs-4"><?php echo htmlspecialchars($request->getBody()); ?></p>

                                        <p class="fs-5"><strong>Request Status:</strong>
                                            <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?>
                                        </p>

                                        <!-----------Buttons------------->
                                        <div class="d-flex flex-column flex-md-row gap-2">
                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="delete_request">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="fs-4 btn bg-custom-red btn-lg text-custom-white custom-border-outset" type="submit">Delete Request</button>
                                            </form>

                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="mark_request_fulfilled">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="fs-4 btn bg-custom-blue text-custom-white btn-lg custom-border-outset" type="submit">Mark Fulfilled</button>
                                            </form>

                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="edit_request">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="fs-4 btn bg-custom-grey text-custom-white btn-lg custom-border-outset" type="submit">Edit Request</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            <?php else : ?>

                                <!--------- fulfilled Requests --------------->
                                <div class="card mb-3 bg-custom-gold border custom-border-inset">
                                    <div class="card-body">
                                        <h5 class="card-title fs-4"><strong><?php echo htmlspecialchars($request->getTitle()); ?></strong></h5>

                                        <?php if (!empty($request->getImages())) : ?>
                                            <div class="mb-2">
                                                <?php foreach ($request->getImages() as $image): ?>
                                                    <img src="<?php echo htmlspecialchars($image->getFileUrl()); ?>" width="200" class="me-2 mb-2 img-thumbnail">
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <p class="card-text fs-4"><?php echo htmlspecialchars($request->getBody()); ?></p>

                                        <p class="fs-5"><strong>Request Status:</strong>
                                            <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?>
                                        </p>

                                        <!------------ Buttons ------------------->
                                        <div class="d-flex gap-2 flex-wrap">
                                            <form action="request_manager/index.php" method="POST">
                                                <input type="hidden" name="action" value="delete_request">
                                                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request->getId()); ?>">
                                                <button class="btn bg-custom-red btn-lg text-custom-white custom-border-outset" type="submit">Delete Request</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <!---------------------- User Feedback ----------------------->
            <div class="card custom-border-outset shadow">
                <div class="card-header text-center fs-4 bg-custom-blue text-custom-white border-0">
                    <?php echo htmlspecialchars($user->getUserName()) . "'s Feedback"; ?>
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