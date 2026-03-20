<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <!-- Profile Sidebar -->
    <div class="col-md-4 col-12 mb-4">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <?php if($data['profile']->banner_image) : ?>
                <img src="<?php echo URLROOT; ?>/uploads/<?php echo $data['profile']->banner_image; ?>" class="card-img-top" style="height: 100px; object-fit: cover;" alt="Banner">
            <?php else : ?>
                <div class="bg-primary bg-opacity-10" style="height: 100px;"></div>
            <?php endif; ?>
            
            <div class="card-body text-center pt-0">
                <div class="mt-n5 position-relative mb-3">
                    <?php if($data['profile']->profile_photo) : ?>
                        <img src="<?php echo URLROOT; ?>/uploads/<?php echo $data['profile']->profile_photo; ?>" class="rounded-circle border border-4 border-white shadow-sm mt-n5" style="width: 100px; height: 100px; object-fit: cover;" alt="Profile">
                    <?php else : ?>
                        <div class="rounded-circle border border-4 border-white shadow-sm bg-white d-inline-flex align-items-center justify-content-center mt-n5" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-fill text-muted display-6"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h4 class="fw-bold mb-1"><?php echo $data['profile']->name . ' ' . $data['profile']->surname; ?></h4>
                <p class="text-muted small mb-3"><?php echo $data['profile']->class ? $data['profile']->class : 'Class not set'; ?></p>
                <div class="d-grid">
                    <a href="<?php echo URLROOT; ?>/students/editProfile" class="btn btn-outline-primary btn-sm rounded-3">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3">
                <h6 class="fw-bold small text-uppercase text-muted mb-2">About Me</h6>
                <p class="small mb-0"><?php echo $data['profile']->about ? nl2br($data['profile']->about) : 'No bio added yet.'; ?></p>
            </div>
        </div>
    </div>

    <!-- Message Feed -->
    <div class="col-md-8 col-12">
        <?php flash('student_message'); ?>
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Messages from My Sponsors</h5>
            </div>
            <div class="card-body p-0">
                <?php if(empty($data['messages'])) : ?>
                    <div class="p-5 text-center">
                        <i class="bi bi-mailbox display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">No approved messages yet.</p>
                    </div>
                <?php endif; ?>

                <?php foreach($data['messages'] as $message) : ?>
                    <div class="p-4 border-bottom last-child-border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0 text-primary"><?php echo $message->sender_name; ?></h6>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($message->created_at)); ?></small>
                        </div>
                        <p class="mb-3 fs-6"><?php echo nl2br($message->content); ?></p>
                        
                        <button class="btn btn-light btn-sm rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#reply-<?php echo $message->id; ?>">
                            <i class="bi bi-reply-fill"></i> Reply
                        </button>

                        <div class="collapse mt-3" id="reply-<?php echo $message->id; ?>">
                            <form action="<?php echo URLROOT; ?>/students/reply" method="POST" class="bg-light p-3 rounded-4">
                                <input type="hidden" name="sponsor_id" value="<?php echo $message->sender_id; ?>">
                                <div class="mb-2">
                                    <textarea name="content" class="form-control border-0 shadow-none" rows="3" placeholder="Write your reply..." required></textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="bi bi-shield-lock"></i> Pending approval</small>
                                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
