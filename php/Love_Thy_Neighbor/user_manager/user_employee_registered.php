<?php require_once '../view/header.php'; ?>

<div class="text-center fs-3 mt-3">
    <h1>Congradulations!! <?php echo htmlspecialchars($user->getUserName());?> </h1>

    <p>You are now a registered user of Love Thy Neighbor!</p>
    <p>You are also a verified Employee of <?php echo htmlspecialchars($business->getName());?></p>
</div>

<?php require_once '../view/footer.php'; ?>