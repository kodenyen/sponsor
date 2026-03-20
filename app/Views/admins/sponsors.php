<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-11 mx-auto">
        <?php flash('sponsor_message'); ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Sponsors</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSponsorModal">
                <i class="bi bi-plus-lg"></i> Add Sponsor
            </button>
        </div>

        <?php foreach($data['sponsors'] as $sponsor) : ?>
            <div class="card mb-4 shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><?php echo $sponsor->name; ?> <small class="text-muted fw-normal">(<?php echo $sponsor->email; ?>)</small></h5>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/generateToken/<?php echo $sponsor->id; ?>">Generate Token</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#">Delete Sponsor</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body py-4">
                    <!-- Token Section -->
                    <?php if($sponsor->token) : ?>
                        <div class="mb-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">Secure Access Link</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo URLROOT; ?>/sponsors/access?token=<?php echo $sponsor->token; ?>" id="token-<?php echo $sponsor->id; ?>">
                                <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('token-<?php echo $sponsor->id; ?>')">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Students Assignment Section -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3">Assigned Students</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <?php 
                                $this->adminModel = $this->model('Admin');
                                $assigned = $this->adminModel->getSponsorAssignments($sponsor->id);
                                if($assigned) : 
                                    foreach($assigned as $student) :
                            ?>
                                <span class="badge bg-light text-dark p-2 rounded-3 border d-flex align-items-center gap-2">
                                    <?php echo $student->name; ?>
                                    <form action="<?php echo URLROOT; ?>/admins/removeAssignment" method="POST" class="d-inline">
                                        <input type="hidden" name="sponsor_id" value="<?php echo $sponsor->id; ?>">
                                        <input type="hidden" name="student_id" value="<?php echo $student->id; ?>">
                                        <button type="submit" class="btn-close" style="font-size: 0.6rem;"></button>
                                    </form>
                                </span>
                            <?php 
                                    endforeach;
                                else : 
                            ?>
                                <p class="text-muted small italic mb-0">No students assigned yet.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Assignment Form -->
                        <form action="<?php echo URLROOT; ?>/admins/assignStudent" method="POST" class="row g-2">
                            <div class="col-8 col-md-4">
                                <select name="student_id" class="form-select form-select-sm" required>
                                    <option value="">Choose a Student...</option>
                                    <?php foreach($data['students'] as $student) : ?>
                                        <option value="<?php echo $student->id; ?>"><?php echo $student->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="hidden" name="sponsor_id" value="<?php echo $sponsor->id; ?>">
                                <button type="submit" class="btn btn-sm btn-success w-100">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Add Sponsor Modal -->
<div class="modal fade" id="addSponsorModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo URLROOT; ?>/admins/addSponsor" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Sponsor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Sponsor</button>
            </div>
        </form>
    </div>
</div>

<script>
function copyToClipboard(id) {
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Link copied to clipboard!");
}
</script>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
