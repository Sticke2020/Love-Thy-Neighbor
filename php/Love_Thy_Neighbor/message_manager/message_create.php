<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<div class="container">
    <h2 class="m-4">Write <?php echo $user->getUserName() ?> A Message</h2>
    <div class="row">

        <div class="card p-0">
            <div class="card-header bg-primary text-white">
                Compose New Message
            </div>
            <!------------------- Compose New Message ------------------>
            <div class="card-body">
        
                <form action="message_manager/index.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">
                    <input type="hidden" name="action" value="send_message">
            
                    <div class="mb-3">
                        <label for="messageBody" class="form-label">Message</label>
                        <textarea name="message_body" id="messageBody" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="btn btn-lg btn-success">Send Message</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>