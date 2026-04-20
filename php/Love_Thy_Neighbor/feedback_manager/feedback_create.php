<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>

<h1 class="mt-4 text-center">Leave Feedback</h1>

<div class="container mt-4">

    <div class="card custom-border-outset mb-4 fs-4">
        <div class="card-header bg-custom-blue">
            Create a New Feedback Message
        </div>
        <div class="card-body bg-custom-light-yellow">
            <form action="feedback_manager/index.php" method="POST">

                <input type="hidden" name="action" value="create_feedback">
                <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($senderId); ?>">
                <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($receiverId); ?>">

                <!--------------- Feedback -------------->
                <div class="mb-3">
                    <label for="body" class="form-label fs-4">Feedback</label>
                    <textarea class="form-control form-control-lg border-2 border-black" id="body" name="comment" rows="6" placeholder="Enter your Feedback here" required></textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="mt-4 btn btn-lg bg-custom-black custom-border-outset text-custom-white w-100 fs-4">Submit Feedback</button>
                </div>

            </form>
        </div>
    </div>

</div>

<?php require_once ('../view/footer.php'); ?>