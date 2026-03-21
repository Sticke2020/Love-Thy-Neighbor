<?php require_once ('../view/user_header.php'); ?>

<h1 class="mt-2 text-center">Leave Feedback</h1>

<div class="container mt-4">

    <div class="card border-primary mb-4">
        <div class="card-header fs-4">
            Create a New Feedback Message
        </div>
        <div class="card-body">
            <form action="feedback_manager/index.php" method="POST">

                <input type="hidden" name="action" value="create_feedback">
                <input type="hidden" name="sender_id" value="<?php echo $senderId ?>">
                <input type="hidden" name="receiver_id" value="<?php echo $receiverId ?>">

                <!-- Feedback -->
                <div class="mb-3">
                    <label for="body" class="form-label fs-4">Feedback</label>
                    <textarea class="form-control" id="body" name="comment" rows="6" placeholder="Enter your Feedback here" required></textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary fs-5">Submit Feedback</button>
                </div>

            </form>
        </div>
    </div>

</div>



<?php require_once ('../view/footer.php'); ?>