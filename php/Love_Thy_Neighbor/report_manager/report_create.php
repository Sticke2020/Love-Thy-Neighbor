<?php 
 require_once '../view/user_header.php'; 
?> 

<h1 class="mt-3 text-center">File A Report</h1>

<div class="container my-4 p-0">

    <div class="card mb-4 custom-border-outset fs-4">
        <div class="card-header bg-custom-blue text-white">
            <h4 class="mb-0">Create Report</h4>
        </div>

        <div class="card-body bg-custom-light-yellow">
            <form action="report_manager/index.php" method="post">
                <input type="hidden" name="action" value="create_report">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId']; ?>">
                <!------------- Report Type Select -------------->
                <div class="mb-3">
                    <label class="form-label">Report Type</label>
                    <select name="report_type_id" class="form-select form-select-lg border-2 border-black" required>
                        <option value="">-- Select Report Type --</option>

                        <?php foreach ($reportTypes as $reportType) { ?>
                            <option value="<?php echo htmlspecialchars($reportType->getId()); ?>">
                                <?php echo htmlspecialchars($reportType->getDescription()); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <!------------------ Report Description ---------->
                <div class="mb-3">
                    <label for="report_body" class="form-label">Description</label>
                    <textarea name="report_body" class="form-control form-control-lg border-2 border-black" rows="5" required placeholder="Write your report here."></textarea>
                </div>

                <button type="submit" class="mt-3 btn btn-lg bg-custom-black custom-border-outset w-100 text-custom-white fs-4">
                    Send Report
                </button>
            </form>
        </div>
    </div>

</div>

<?php require_once '../view/footer.php'; ?>