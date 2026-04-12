<?php 
 require_once '../view/user_header.php'; 
?> 

<div class="container my-4">

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">File A Report</h4>
        </div>

        <div class="card-body">
            <form action="report_manager/index.php" method="post">
                <input type="hidden" name="action" value="create_report">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId'] ?>">
                <!------------- Report Type Select -------------->
                <div class="mb-3">
                    <label class="form-label">Report Type</label>
                    <select name="report_type_id" class="form-select">
                        <option value="">-- Select Report Type --</option>

                        <?php foreach ($reportTypes as $reportType) { ?>
                            <option value="<?php echo $reportType->getId(); ?>">
                                <?php echo htmlspecialchars($reportType->getDescription()); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <!------------------ Report Description ---------->
                <div class="mb-3">
                    <label for="report_body" class="form-label">Description</label>
                    <textarea name="report_body" class="form-control" rows="5" required placeholder="Write your report here."></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Send Report
                </button>
            </form>
        </div>
    </div>

</div>

<?php require_once '../view/footer.php'; ?>