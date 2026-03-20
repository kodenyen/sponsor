<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <h2 class="mb-4">Admin Dashboard</h2>
        
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3 class="display-5 fw-bold"><?php echo $data['counts']['sponsors']; ?></h3>
                    <p class="text-muted mb-0">Total Sponsors</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3 class="display-5 fw-bold"><?php echo $data['counts']['students']; ?></h3>
                    <p class="text-muted mb-0">Total Students</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3 class="display-5 fw-bold text-primary"><?php echo $data['counts']['pending_messages']; ?></h3>
                    <p class="text-muted mb-0">Pending Messages</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-12">
                <div class="card p-3 h-100">
                    <h5 class="card-title mb-4">Management</h5>
                    <div class="d-grid gap-3">
                        <a href="<?php echo URLROOT; ?>/admins/messages" class="btn btn-primary btn-lg py-3">
                            <i class="bi bi-chat-dots"></i> Review Messages
                        </a>
                        <a href="<?php echo URLROOT; ?>/admins/sponsors" class="btn btn-outline-primary btn-lg py-3">
                            <i class="bi bi-people"></i> Manage Sponsors
                        </a>
                        <a href="<?php echo URLROOT; ?>/admins/students" class="btn btn-outline-primary btn-lg py-3">
                            <i class="bi bi-mortarboard"></i> Manage Students
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card p-3 h-100">
                    <h5 class="card-title mb-4">Tools</h5>
                    <div class="d-grid gap-3">
                        <a href="<?php echo URLROOT; ?>/admins/forms" class="btn btn-outline-secondary btn-lg py-3">
                            <i class="bi bi-file-earmark-plus"></i> Form Builder
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
