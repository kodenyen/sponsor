<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-12">
        <div class="card p-4 mt-5">
            <h2 class="text-center mb-4">Login</h2>
            <p class="text-center text-muted mb-4">Please fill in your credentials to log in</p>
            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg mt-3">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
