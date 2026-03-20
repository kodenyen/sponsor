<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-11 mx-auto">
        <?php flash('form_message'); ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Form Builder</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal">
                <i class="bi bi-file-earmark-plus"></i> Create Form
            </button>
        </div>

        <div class="row g-4">
            <?php foreach($data['forms'] as $form) : ?>
                <div class="col-md-6 col-12">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between">
                            <h5 class="mb-0 fw-bold"><?php echo $form->title; ?></h5>
                            <span class="badge bg-light text-dark rounded-pill border text-capitalize"><?php echo $form->target_role; ?></span>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3"><?php echo $form->description; ?></p>
                            <h6 class="fw-bold small text-uppercase text-muted">Field Configuration</h6>
                            <ul class="list-group list-group-flush small">
                                <?php 
                                    $fields = json_decode($form->fields);
                                    foreach($fields as $field) :
                                ?>
                                    <li class="list-group-item bg-transparent px-0 py-2">
                                        <i class="bi bi-dot"></i> <?php echo $field->label; ?> 
                                        <span class="badge bg-light text-muted fw-normal float-end border"><?php echo $field->type; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Form Modal -->
<div class="modal fade" id="addFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo URLROOT; ?>/admins/addForm" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Communication Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Form Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="Progress Update Form">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign To</label>
                    <select name="target_role" class="form-select" required>
                        <option value="sponsor">Sponsor</option>
                        <option value="student">Student</option>
                    </select>
                </div>

                <hr>
                <h6 class="fw-bold mb-3">Custom Fields</h6>
                <div id="fields-area">
                    <div class="row g-2 mb-2 field-row">
                        <div class="col-7">
                            <input type="text" name="field_labels[]" class="form-control" required placeholder="Field Name (e.g. Current GPA)">
                        </div>
                        <div class="col-4">
                            <select name="field_types[]" class="form-select" required>
                                <option value="text">Short Text</option>
                                <option value="textarea">Long Text</option>
                                <option value="file">File Upload</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-outline-danger w-100 remove-field">&times;</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-field-btn">
                    <i class="bi bi-plus-circle"></i> Add More Field
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Form</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('add-field-btn').addEventListener('click', function() {
    const area = document.getElementById('fields-area');
    const firstRow = area.querySelector('.field-row');
    const newRow = firstRow.cloneNode(true);
    newRow.querySelector('input').value = '';
    newRow.querySelector('.remove-field').addEventListener('click', function() {
        if(area.querySelectorAll('.field-row').length > 1) newRow.remove();
    });
    area.appendChild(newRow);
});

document.querySelectorAll('.remove-field').forEach(btn => {
    btn.addEventListener('click', function() {
        const area = document.getElementById('fields-area');
        if(area.querySelectorAll('.field-row').length > 1) btn.closest('.field-row').remove();
    });
});
</script>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
