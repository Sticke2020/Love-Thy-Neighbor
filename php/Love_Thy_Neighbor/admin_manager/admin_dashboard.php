<?php require_once ('../view/admin_header.php'); ?>

<div class="container-fluid px-0 mb-3">
    <div class="row align-items-start gy-3">

        <!-------------- Admin Profile Image ---------------->
        <div class="col-12 col-md-3">
            <div class="d-inline-block">
                <?php if ($profilePic == null) { ?>
                    <img class="img-fluid custom-border-outset" src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo htmlspecialchars(urlencode($user->getUserName())); ?>">
                <?php } else { ?>
                    <img class="img-fluid custom-border-outset" src="<?php echo htmlspecialchars($profilePic->getFileUrl()); ?>">
                <?php } ?>

                <form action="image_manager/index.php" method="POST">
                    <input type="hidden" name="action" value="add_profile_image" />
                    <input class="mt-2 btn bg-custom-black text-custom-white btn-lg custom-border-outset fs-4 w-100" type="submit" value="Change Profile Image" />
                </form>
            </div>
        </div> 

        <!------------------ Admin Profile Data ----------------->
        <div class="col-12 col-md-6 text-center">
            <h1 class="mt-1"><?php echo htmlspecialchars($user->getUserName()); ?></h1>
            <h1 class="mt-2">Site Admin</h1>      
        </div>

        <!-- ---------Messages Button blinks if there are unread messages -------->
        <?php if ($unreadMessages == true) { ?>
        <div class="col-12 col-md-3">
            <form action="message_manager/index.php" method="POST" class="text-md-end mt-3">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                <button class="btn bg-custom-blue text-custom-white btn-lg custom-border-outset fs-4 w-100"
                    id="inbox_button_blink" type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } else { ?>
        <div class="col-12 col-md-3"> <!-------------- No unread messages button is solid no blinking ------->
            <form action="message_manager/index.php" method="POST" class="text-md-end mt-3">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                <button class="btn bg-custom-black text-custom-white btn-lg custom-border-outset fs-4 w-100"
                         type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } ?>
    </div>
</div>

<!--------------------- Search reports ------------------------->
<div class="d-flex flex-column flex-md-row justify-content-center gap-4 fs-4 mt-3">
    <fieldset class="m-2 text-center fs-4">
        <form action="report_manager/index.php" method="POST">
            <label id="search">Search Reports By UserName:</label>
            <input class='text_input' type="text" name="search_username">
            <input type="hidden" name="action" value="search_reports_by_username" /> 
            <input class='clickable' type="submit" value="Search"><br>
        </form>
    </fieldset>
    <fieldset class="m-2 text-center fs-4">
        <form action="report_manager/index.php" method="POST">
            <label id="search">Search Reports Report TypeId:</label>
            <input class='text_input' type="text" name="search_report_id">
            <input type="hidden" name="action" value="search_reports_by_type_id" /> 
            <input class='clickable' type="submit" value="Search"><br>
        </form>
    </fieldset>
</div>

<!------------------------------------- User Reports ------------------------------->
<div class="container-fluid mt-3 px-0">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header text-center fs-4 bg-custom-black text-custom-white">
                    Reports
                </div>
                <div class="card-body bg-custom-blue">
                    <?php if (empty($reports)) : ?>
                        <p class="text-muted text-custom-white fs-4">No reports found.</p>
                    <?php else : ?>
                        <?php foreach ($reports as $report) : ?>
                            <div class="card mb-3 bg-custom-gold border custom-border-inset">
                                <div class="card-body">
                                    <h5 class="card-title fs-4">UserName: <?php echo htmlspecialchars($report->getUserName()); ?></h5>
                                    <p class="fs-5"><strong>Report Type:</strong>
                                        <?php echo htmlspecialchars($report->getReportTypeId()) . " " . htmlspecialchars($report->getReportTypes()); ?>
                                    </p>
                                    <p class="card-text fs-4"><?php echo htmlspecialchars($report->getBody()); ?></p>
                                    <p class="fs-5"><strong>Date Created:</strong>
                                        <?php echo htmlspecialchars($report->getDateCreated()); ?>
                                    </p>
                                    <form action="report_manager/index.php" method="POST">
                                        <input type="hidden" name="action" value="delete_report" />
                                        <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report->getId()); ?>">
                                        <button class="btn text-custom-white btn-lg bg-custom-red fs-4 custom-border-outset"
                                            type="submit">Delete Report</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<fieldset class="w-25">
<p class="mt-3 fs-5">This button will hash the passwords in the DB if the DB was reset and the passwords are plain text</p>
<div class="mt-1">
    <form method="POST" action="admin_manager/index.php">
        <input type="hidden" name="action" value="hash_passwords">
        <input type="submit" class="btn btn-lg bg-custom-black text-custom-white" value="Hash Passwords">
    </form>
</div>
</fieldset>

<?php require_once ('../view/footer.php'); ?>