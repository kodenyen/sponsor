<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-10 text-center">
        <h1 class="display-4 mb-4" style="color: var(--primary-color);"><?php echo $data['title']; ?></h1>
        <p class="lead mb-5">A secure platform connecting sponsors with scholarship students.</p>
        <div class="row g-3 justify-content-center">
            <div class="col-md-4 col-12">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-primary btn-lg w-100 p-3">
                    <i class="bi bi-lock"></i> Login
                </a>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
