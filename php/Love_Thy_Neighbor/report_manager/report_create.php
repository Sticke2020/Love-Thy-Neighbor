<?php 
 require_once '../view/user_header.php'; 
?> 

<div class="container my-4">

    <!-- Edit User -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">File A Report</h4>
        </div>

        <div class="card-body">
            <form action="user_manager/index.php" method="post">
                <input type="hidden" name="action" value="create_report">

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

                

                <button type="submit" class="btn btn-success w-100">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

</div>

<?php require_once '../view/footer.php'; ?>