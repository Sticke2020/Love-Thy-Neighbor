
<?php require_once ('../view/request_header.php'); ?>

<section>
    
    <?php foreach ($requests as $request) :?>
    <fieldset>
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
        </div>
    </fieldset>
    <?php endforeach; ?>
    
</section>


<?php require_once ('../view/footer.php'); ?>