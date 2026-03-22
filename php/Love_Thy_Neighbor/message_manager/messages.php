
<?php require_once ('../view/user_header.php'); ?>


 <style>
        .message-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .message-item {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        .message-item:hover {
            background-color: #f8f9fa;
        }
        .message-item strong {
            display: block;
        }
        .message-content, .compose-message {
            min-height: 200px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fdfdfe;
            margin-bottom: 20px;
        }
        .compose-message textarea {
            resize: vertical;
        }
    </style>

<div class="container my-4">
    <h2 class="mb-4">Messages</h2>

    <div class="row">
        <!-- Left Panel: Inbox -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Inbox
                </div>
                <div class="card-body message-list">
                    <?php foreach ($messages as $message) : ?>
                    <form action="message_manager/index.php" method="POST">
                        <input type="hidden" name="action" value="message_content">
                        <input type="hidden" name="message_id" value="<?php echo $message->getId() ?>">
                        <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                        <button type="submit" class="message-item btn btn-link text-start w-100">
                            <strong><?php echo $message->getSender() ?></strong>
                            <small class="text-muted"><?php echo substr($message->getBody(), 0, 59); ?></small>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Right Panel: Message Content & Compose -->
        <div class="col-md-8">
            <!-- Message Content -->
            <div class="message-content mb-3">
                <?php
                if (isset($messageContent)) {
                    echo $messageContent->getBody();
                } else {
                    echo "<p class='text-muted'>Select a message from the inbox to view its content.</p>";
                }
                ?>
            </div>

            <!-- Compose New Message -->
            <div class="compose-message">
                <h5>Compose New Message</h5>

                <form action="message_manager/index.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $userId ?>">

                    <div class="mb-3">
                        <label for="recipient" class="form-label">Recipient</label>
                        <input type="hidden" name="action" value="send_message">
                        <input type="text" name="recipient_username" placeholder="Start typing a username"
                            list="userList" id="recipient" class="form-control" required>

                        <datalist id="userList">
                            <?php foreach ($userNames as $userName): ?>
                                <option value="<?php echo htmlspecialchars($userName->getUserName()); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="messageBody" class="form-label">Message</label>
                        <textarea name="message_body" id="messageBody" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="btn btn-success">Send Message</button>
                </form>

            </div>
        </div>
    </div>
</div>


<?php require_once ('../view/footer.php'); ?>