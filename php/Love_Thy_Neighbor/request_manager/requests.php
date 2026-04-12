
<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<?php if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) : ?>
    <fieldset class="m-2">
        <form action="request_manager/index.php" method="POST">
            <label id="search">Search Requests By User Id:</label>
            <input class='text_input' type="text" name="requests_by_user_id">
            <input type="hidden" name="action" value="requests_by_user_id" /> 
            <input type="submit" value="Search"><br>
        </form>
    </fieldset>
<?php endif; ?>

<div class="container-fluid mt-3 px-0">

    <div class="card">
        <div class="card-header text-center fs-1 bg-custom-light-yellow">
            Requests
        </div>

        <div class="card-body bg-custom-blue">
            <?php if (empty($requests)) : ?>
                <p class="text-muted">No requests found.</p>
            <?php else : ?>
                <?php foreach ($requests as $request) : ?>
                    <div class="card mb-3 bg-custom-gold border custom-border-inset">

                        <div class="card-header fs-4 row m-3">
                            <form action="user_manager/index.php" method="POST" class="d-inline-block align-top col-auto">
                                <input type="hidden" name="action" value="view_user">
                                <input type="hidden" name="user_id" value="<?php echo $request->getUserId(); ?>">

                                <button type="submit" style="border: none; background: none; padding: 0;">
                                    <img src="<?php echo $request->getUserImage(); ?>"
                                        class="me-2 mb-2 img-thumbnail"
                                        style="width:100px; height:100px; object-fit:cover;">
                                </button>
                            </form>
                            <p class="col mt-4 fs-4"><?php echo $request->getUserName() ?></p>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title fs-2 mb-4">Title: <?php echo $request->getTitle(); ?></h5>

                            <?php if (!empty($request->getImages())) : ?>
                                <div class="mb-2">
                                    <?php foreach ($request->getImages() as $image): ?>
                                        <img src="<?php echo $image->getFileUrl(); ?>" width="200" class="me-2 mb-2 img-thumbnail">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <p class="card-text fs-2"><?php echo $request->getBody(); ?></p>

                            <hr>

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