<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-8 col-12 mx-auto">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Edit My Profile</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo URLROOT; ?>/students/updateProfile" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Surname</label>
                            <input type="text" name="surname" class="form-control rounded-3" value="<?php echo $data['profile']->surname; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Age</label>
                            <input type="number" name="age" class="form-control rounded-3" value="<?php echo $data['profile']->age; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Class / Year</label>
                        <input type="text" name="class" class="form-control rounded-3" value="<?php echo $data['profile']->class; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">About Me</label>
                        <textarea name="about" class="form-control rounded-3" rows="4"><?php echo $data['profile']->about; ?></textarea>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Profile Photo</label>
                        <input type="file" name="profile_photo" class="form-control rounded-3" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control rounded-3" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Academic Results (PDF Only)</label>
                        <input type="file" name="result_files[]" class="form-control rounded-3" accept=".pdf" multiple>
                        
                        <?php if($data['profile']->result_files) : ?>
                            <div class="mt-3">
                                <h6 class="small fw-bold text-muted">Current Files:</h6>
                                <ul class="list-group list-group-flush small">
                                    <?php 
                                        $files = json_decode($data['profile']->result_files);
                                        foreach($files as $file) :
                                    ?>
                                        <li class="list-group-item bg-transparent px-0">
                                            <i class="bi bi-file-pdf text-danger"></i> <?php echo basename($file); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 rounded-3">Save Changes</button>
                        <a href="<?php echo URLROOT; ?>/students/dashboard" class="btn btn-light py-2 rounded-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
