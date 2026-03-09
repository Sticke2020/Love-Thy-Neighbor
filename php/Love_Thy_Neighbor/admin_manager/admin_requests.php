<?php require_once ('../view/admin_header.php'); ?>

<section>
    
<fieldset>
    <form action="admin_manager/index.php" method="POST">
        <label id="search">Search Requests By User Id:</label>
        <input class='text_input' type="text" name="requests_by_user_id">
        <input type="hidden" name="action" value="requests_by_user_id" /> 
        <input type="submit" value="Search"><br>
    </form>
</fieldset>


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