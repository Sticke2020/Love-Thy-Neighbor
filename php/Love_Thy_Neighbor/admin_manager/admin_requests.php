<?php require_once ('../view/admin_header.php'); ?>

<section>
    
<fieldset class="m-2">
    <form action="admin_manager/index.php" method="POST">
        <label id="search">Search Requests By User Id:</label>
        <input class='text_input' type="text" name="requests_by_user_id">
        <input type="hidden" name="action" value="requests_by_user_id" /> 
        <input type="submit" value="Search"><br>
    </form>
</fieldset>


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
                    <div class="card mb-3 bg-custom-gold">
                        <div class="card-body">
                            <h5 class="card-title fs-1"><?php echo $request->getTitle(); ?></h5>

                            <?php if (!empty($request->getImages())) : ?>
                                <div class="mb-2">
                                    <?php foreach ($request->getImages() as $image): ?>
                                        <img src="<?php echo $image->getFileUrl(); ?>" width="200" class="me-2 mb-2 img-thumbnail">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <p class="card-text fs-2"><?php echo $request->getBody(); ?></p>

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