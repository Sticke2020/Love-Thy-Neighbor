
<?php require_once ('../view/request_header.php'); ?>

<div class="container-fluid mt-3 px-0">
    <div class="card">
        <div class="card-header text-center fs-4 bg-custom-light-yellow">
            Requests
        </div>
        <div class="card-body bg-custom-blue">
            <?php if (empty($requests)) : ?>
                <p class="text-muted">No requests found.</p>
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

                            <p><strong>Date Created:</strong>
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