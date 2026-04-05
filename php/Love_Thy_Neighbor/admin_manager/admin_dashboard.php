<?php require_once ('../view/admin_header.php'); ?>

<div class="container-fluid px-0 mb-3">
    <div class="row align-items-start">

        <!--User Profile Image-->
        <div class="col-auto" style="max-width: 40%; max-height: 500px;" >

            <?php if ($profilePic == null) { ?>
                <img class="img-fluid" src="https://api.dicebear.com/9.x/initials/svg?seed=<?php echo urlencode($user->getUserName())?>">
            <?php } else { ?>
                <img class="img-fluid" src="<?php echo $profilePic->getFileUrl(); ?>">
            <?php } ?>

            <form action="image_manager/index.php" method="POST">
                <input type="hidden" name="action" value="add_profile_image" />
                <input class="btn bg-custom-white w-100 mt-2 fs-4" type="submit" value="Change Profile Image" />
            </form>

        </div> 

        <!--User Profile Data such as Name and Business-->
        <div class="col">
            <h1 class="mt-1"><?php echo $user->getUserName()?></h1>
            <h1 class="mt-2">Site Admin</h1>      
        </div>

        <!--Messages Button blinks if there are unread messages-->
        <?php if ($unreadMessages == true) { ?>
        <div class="col">
            <form action="message_manager/index.php" method="POST" class="text-end m-5">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">
                <button class="btn text-custom-white btn-lg border-3"
                    id="inbox_button_blink" type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } else { ?>
        <div class="col">
            <form action="message_manager/index.php" method="POST" class="text-end m-5">
                <input type="hidden" name="action" value="messages">
                <input type="hidden" name="user_id" value="<?php echo $user->getId() ?>">
                <button class="btn bg-custom-blue text-custom-white btn-lg border-white border-3"
                         type="submit">Check Your Messages</button> 
            </form>
        </div>
        <?php } ?>
    </div>
</div>

<!--  Search reports by username  -->
<fieldset class="m-2 text-center">
    <form action="report_manager/index.php" method="POST">
        <label id="search">Search Reports By UserName:</label>
        <input class='text_input' type="text" name="search_username">
        <input type="hidden" name="action" value="search_reports_by_username" /> 
        <input class='clickable' type="submit" value="Search"><br>
    </form>
</fieldset>

<div class="container-fluid mt-3 px-0">
    <div class="row">
        <div class="col">

            <!--User Reports-->
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
                                    <h5 class="card-title fs-4">UserName: <?php echo $report->getUserName(); ?></h5>
                                    <p class="fs-5"><strong>Report Type:</strong>
                                        <?php echo $report->getReportTypeId() . " " . $report->getReportTypes(); ?>
                                    </p>
                                    <p class="card-text fs-4"><?php echo $report->getBody(); ?></p>
                                    <p class="fs-5"><strong>Date Created:</strong>
                                        <?php echo $report->getDateCreated(); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ('../view/footer.php'); ?>