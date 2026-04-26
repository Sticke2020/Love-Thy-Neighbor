
<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/request_header.php');
} ?>

<?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) : ?>
    <fieldset class="m-2 fs-4 text-center">
        <form action="request_manager/index.php" method="POST">
            <label id="search">Search Requests By User Id:</label>
            <input class='text_input' type="text" name="requests_by_user_id">
            <input type="hidden" name="action" value="requests_by_user_id" /> 
            <input type="submit" value="Search"><br>
        </form>
    </fieldset>
<?php endif; ?>


<div class="d-flex flex-column flex-md-row justify-content-center gap-4 fs-4 mt-3">
    <form action="request_manager/index.php" method="POST">
        <input type="hidden" name="action" value="unfulfilled_requests">
        <input type="submit" value="Unfulfilled Requests" class="fs-4 btn btn-lg bg-custom-black text-custom-white custom-border-outset">
    </form>
    <form action="request_manager/index.php" method="POST">
        <input type="hidden" name="action" value="fulfilled_requests">
        <input type="submit" value="Fulfilled Requests" class="fs-4 btn btn-lg bg-custom-black text-custom-white custom-border-outset">
    </form>
</div>

<div class="container-fluid mt-3 px-0">

    <div class="card fs-4 custom-border-outset">
        <div class="fs-4 card-header text-center bg-custom-blue border-0 text-custom-white">
            <h3>Requests</h3>
        </div>

        <div class="card-body bg-custom-blue">
            <?php if (empty($requests)) : ?>
                <p class="text-muted">No requests found.</p>
            <?php else : ?>
                <?php foreach ($requests as $request) : ?>
                    <div class="card mb-4 bg-custom-gold border custom-border-inset">
                        <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-md-between fs-4 m-3 mb-1 custom-border-outset">
                            <h5 class="card-title fs-2 mb-2 order-2 order-md-1">Title: <?php echo htmlspecialchars($request->getTitle()); ?></h5>

                            <div class="d-flex flex-column align-items-center justify-content-center mt-2 mt-md-0 order-1 order-md-2">
                                <form action="user_manager/index.php" method="POST" class="mb-0">
                                    <input type="hidden" name="action" value="view_user">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($request->getUserId()); ?>">

                                    <button type="submit" style="border: none; background: none; padding: 0;">
                                        <img src="<?php echo htmlspecialchars($request->getUserImage()); ?>"
                                            class="me-2 mb-0 img-thumbnail"
                                            style="width:100px; height:100px; object-fit:cover;">
                                    </button>
                                </form>
                                <p class="fs-4 mb-0 text-center"><?php echo htmlspecialchars($request->getUserName()); ?></p>
                            </div>
                        </div>

                        <div class="card-body m-3 mt-1 custom-border-outset">

                            <p class="card-text fs-2"><?php echo htmlspecialchars($request->getBody()); ?></p>

                            <?php if (!empty($request->getImages())) : ?>
                                <div class="mb-2">
                                    <?php foreach ($request->getImages() as $image): ?>
                                        <img src="<?php echo htmlspecialchars($image->getFileUrl()); ?>" width="200" class="me-2 mb-2 img-thumbnail">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <p class="fs-3"><strong>Request Status:</strong>
                                <?php echo ($request->getRequestStatusTypeId() == 1) ? 'Unfulfilled' : 'Fulfilled'; ?>
                            </p>

                            <p class="fs-4"><strong>Date Created:</strong>
                                 <?php echo $request->getDateCreated(); ?> 
                                    <strong>Date Updated:</strong> <?php echo $request->getDateUpdated(); ?>
                            </p> 

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>