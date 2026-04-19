<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<div class="container">
    <h1 class="m-4 text-center">Write <?php echo $user->getUserName() ?> A Message</h1>
    <div class="row">

        <div class="card p-0 custom-border-outset fs-4">
            <div class="card-header bg-primary text-white">
                Compose New Message
            </div>
            <!------------------- Compose New Message ------------------>
            <div class="card-body bg-custom-light-yellow">
        
                <form action="message_manager/index.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">
                    <input type="hidden" name="action" value="send_message">
            
                    <div class="mb-3">
                        <label for="messageBody" class="form-label">Message</label>
                        <textarea name="message_body" id="messageBody" class="form-control form-control-lg border-2 border-black" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="mt-4 btn btn-lg bg-custom-black custom-border-outset text-custom-white w-100 fs-4">Send Message</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>