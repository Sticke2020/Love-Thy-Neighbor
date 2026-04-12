<?php 
if (isset($_SESSION['user']) && $_SESSION['user']->getUserTypeId() == 1) {
    require_once ('../view/admin_header.php');
} else {
    require_once ('../view/user_header.php');
} ?>


<div class="container my-4">
    <h2 class="mb-4">Messages</h2>

    <div class="row">
        <!---------------------- Inbox ----------------------->
        <div class="col-md-4">

            <div class="card">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0">Inbox</h4>
                </div>

                <div class="card-body message-list bg-custom-light-yellow">
                    <?php foreach ($inbox as $message) : ?>
                    <form action="message_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="message_content">
                        <input type="hidden" name="message_id" value="<?php echo $message->getId() ?>">
                        <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                        <button type="submit" class="message-item btn btn-link text-start w-100 fs-4">
                            <strong>From: <?php echo $message->getSender() ?></strong>
                            <small class="text-muted"><?php echo substr($message->getBody(), 0, 59); ?></small>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>

            </div>
            <!---------------------- Outbox ----------------------->
            <div class="card mt-2">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0">Outbox</h4>
                </div>

                <div class="card-body message-list bg-custom-light-yellow">
                    <?php foreach ($outbox as $sent) : ?>
                    <form action="message_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="message_content">
                        <input type="hidden" name="message_id" value="<?php echo $sent->getId() ?>">
                        <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                        <button type="submit" class="message-item btn btn-link text-start w-100 fs-4">
                            <strong>To: <?php echo $sent->getReceiver() ?></strong>
                            <small class="text-muted"><?php echo substr($sent->getBody(), 0, 59); ?></small>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>

        <!------------------ Message Content and New Message ------------>
        <div class="col-md-8">

            <div class="card mb-2">
                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0">Message Content</h4>
                </div>
                <!-------------- Message Content ---------------->
                <div class="card-body bg-custom-light-yellow fs-4">
                    <?php
                    if (isset($messageContent)) {
                        echo "<p>Sent By: " . $messageContent->getSender() . "</p>";
                        echo $messageContent->getBody();
                        echo "<br>";
                        echo "<br>";
                        echo $messageContent->getDateCreated();
                        echo "<br>";
                        echo "<br>";
                    ?>
                        <form action="message_manager/index.php" method="POST" class="text-end">
                            <input type="hidden" name="action" value="delete_message">
                            <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                            <input type="hidden" name="message_id" value="<?php echo $messageId ?>">
                            <button type="submit" name="delete_message" class="btn btn-lg bg-custom-red text-custom-white">Delete Message</button>
                        </form>
                    <?php
                    } else {
                        echo "<p class='text-muted'>Select a message from the inbox to view its content.</p>";
                    }
                    ?>
                </div>

            </div>
            <div class="card mb-2">

                <div class="card-header bg-custom-blue text-custom-white">
                    <h4 class="mb-0">Compose New Message</h4>
                </div>
                <!---------- Compose New Message -------------->
                <div class="card-body bg-custom-light-yellow fs-4">
            
                    <form action="message_manager/index.php" method="POST" class="text-end">
                        <input type="hidden" name="user_id" value="<?php echo $userId ?>">

                        <div class="mb-3 text-start">
                            <label for="recipient" class="form-label">Recipient</label>
                            <input type="hidden" name="action" value="send_message">
                            <input type="text" name="recipient_username" placeholder="Start typing a username"
                                list="userList" id="recipient" class="form-control form-control-lg" required>

                            <datalist id="userList">
                                <?php foreach ($userNames as $userName): ?>
                                    <option value="<?php echo htmlspecialchars($userName->getUserName()); ?>">
                                <?php endforeach; ?>
                            </datalist>

                        </div>

                        <div class="mb-3 text-start">
                            <label for="messageBody" class="form-label">Message</label>
                            <textarea name="message_body" id="messageBody" class="form-control form-control-lg" rows="5" required></textarea>
                        </div>

                        <button type="submit" name="send_message" class="btn btn-lg btn-success">Send Message</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once ('../view/footer.php'); ?>