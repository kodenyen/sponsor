<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <?php flash('sponsor_message'); ?>
        <h2 class="mb-4">Sponsor Dashboard</h2>
        
        <!-- Dynamic Forms Section -->
        <?php 
            $sponsorForms = array_filter($data['forms'], function($f) { return $f->target_role == 'sponsor'; });
            if(!empty($sponsorForms)) :
        ?>
            <div class="mb-5">
                <h5 class="mb-3 fw-bold">Communication Forms</h5>
                <div class="row g-3">
                    <?php foreach($sponsorForms as $form) : ?>
                        <div class="col-md-4 col-12">
                            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                                <div class="mb-2"><i class="bi bi-file-earmark-text text-primary display-6"></i></div>
                                <h6 class="fw-bold mb-1"><?php echo $form->title; ?></h6>
                                <p class="small text-muted mb-3"><?php echo $form->description; ?></p>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#dynamicForm-<?php echo $form->id; ?>">Open Form</button>
                            </div>
                        </div>

                        <!-- Dynamic Form Modal -->
                        <div class="modal fade" id="dynamicForm-<?php echo $form->id; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="<?php echo URLROOT; ?>/sponsors/submitForm" method="POST" enctype="multipart/form-data" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php echo $form->title; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="form_id" value="<?php echo $form->id; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Select Student</label>
                                            <select name="student_id" class="form-select" required>
                                                <?php foreach($data['students'] as $student) : ?>
                                                    <option value="<?php echo $student->id; ?>"><?php echo $student->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <?php 
                                            $fields = json_decode($form->fields);
                                            foreach($fields as $index => $field) :
                                        ?>
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo $field->label; ?></label>
                                                <?php if($field->type == 'text') : ?>
                                                    <input type="text" name="field_<?php echo $index; ?>" class="form-control" required>
                                                <?php elseif($field->type == 'textarea') : ?>
                                                    <textarea name="field_<?php echo $index; ?>" class="form-control" rows="3" required></textarea>
                                                <?php elseif($field->type == 'file') : ?>
                                                    <input type="file" name="field_<?php echo $index; ?>" class="form-control" required>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary w-100 py-2">Submit for Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <h5 class="mb-3 fw-bold">My Assigned Students</h5>
        <div class="row g-4 mb-5">
            <?php foreach($data['students'] as $student) : ?>
                <div class="col-md-6 col-12">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="position-relative">
                            <?php if($student->banner_image) : ?>
                                <img src="<?php echo URLROOT; ?>/uploads/<?php echo $student->banner_image; ?>" class="card-img-top rounded-4 rounded-bottom-0" style="height: 120px; object-fit: cover;" alt="Banner">
                            <?php else : ?>
                                <div class="bg-primary rounded-4 rounded-bottom-0" style="height: 120px; opacity: 0.1;"></div>
                            <?php endif; ?>
                            
                            <div class="position-absolute top-100 start-0 translate-middle-y ps-4">
                                <?php if($student->profile_photo) : ?>
                                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo $student->profile_photo; ?>" class="rounded-circle border border-4 border-white shadow-sm" style="width: 80px; height: 80px; object-fit: cover;" alt="Profile">
                                <?php else : ?>
                                    <div class="rounded-circle border border-4 border-white shadow-sm bg-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi bi-person-fill text-muted display-6"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-body pt-5 px-4">
                            <h5 class="card-title fw-bold mb-1"><?php echo $student->name . ' ' . $student->surname; ?></h5>
                            <p class="text-muted small mb-4"><?php echo $student->class ? $student->class : 'No class set'; ?></p>
                            
                            <button class="btn btn-primary w-100 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#msgModal-<?php echo $student->id; ?>">
                                <i class="bi bi-chat-dots-fill"></i> Send Message
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Message Modal -->
                <div class="modal fade" id="msgModal-<?php echo $student->id; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="<?php echo URLROOT; ?>/sponsors/sendMessage" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Quick Message to <?php echo $student->name; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="student_id" value="<?php echo $student->id; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Your Message</label>
                                    <textarea name="content" class="form-control" rows="5" required placeholder="Type your message here..."></textarea>
                                </div>
                                <div class="alert alert-info py-2 small border-0">
                                    <i class="bi bi-shield-lock"></i> All messages are reviewed by admins before delivery.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary px-4">Submit for Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if(empty($data['students'])) : ?>
                <div class="col-12">
                    <div class="card p-5 text-center shadow-sm border-0 rounded-4 bg-light">
                        <i class="bi bi-person-dash display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">No students are currently assigned to you.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
