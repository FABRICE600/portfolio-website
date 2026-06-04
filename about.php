<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "About Me - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';

$user = getUserData($pdo);
$education = getEducation($pdo);
$experience = getExperience($pdo);
?>

<section class="about-section py-5">
    <div class="container">
        <h1 class="text-center mb-5">About Me</h1>
        <div class="row">
            <div class="col-md-4" data-aos="fade-right">
                <img src="assets/uploads/profile/<?php echo isset($user['profile_image']) ? $user['profile_image'] : 'default-avatar.png'; ?>" class="img-fluid rounded-circle mb-4" style="width: 100%; max-width: 250px;">
                <div class="info-box p-3 border rounded">
                    <h4>Personal Info</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-user me-2"></i> <?php echo isset($user['full_name']) ? $user['full_name'] : 'John Doe'; ?></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo isset($user['email']) ? $user['email'] : 'admin@portfolio.com'; ?></li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Rwanda</li>
                        <li class="mb-2"><i class="fas fa-graduation-cap me-2"></i> Software Development Student</li>
                    </ul>
                    <a href="download-cv.php" class="btn btn-primary w-100 mt-3"><i class="fas fa-download me-2"></i>Download CV</a>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-left">
                <div class="bio-box mb-4">
                    <h3>Biography</h3>
                    <p><?php echo isset($user['bio']) ? nl2br(htmlspecialchars($user['bio'])) : 'Passionate software development student with expertise in web development.'; ?></p>
                </div>
                <?php if(is_array($education) && count($education) > 0): ?>
                <div class="education-box mb-4">
                    <h3><i class="fas fa-graduation-cap me-2"></i>Education</h3>
                    <?php foreach($education as $edu): ?>
                        <div class="timeline-item mb-3">
                            <div class="timeline-year text-primary fw-bold"><?php echo $edu['year_start']; ?> - <?php echo $edu['year_end'] ?? 'Present'; ?></div>
                            <div class="timeline-title fw-bold"><?php echo $edu['degree']; ?></div>
                            <div class="timeline-subtitle text-muted"><?php echo $edu['institution']; ?></div>
                            <p><?php echo $edu['description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if(is_array($experience) && count($experience) > 0): ?>
                <div class="experience-box">
                    <h3><i class="fas fa-briefcase me-2"></i>Experience</h3>
                    <?php foreach($experience as $exp): ?>
                        <div class="timeline-item mb-3">
                            <div class="timeline-year text-primary fw-bold"><?php echo $exp['year_start']; ?> - <?php echo $exp['year_end'] ?? 'Present'; ?></div>
                            <div class="timeline-title fw-bold"><?php echo $exp['position']; ?></div>
                            <div class="timeline-subtitle text-muted"><?php echo $exp['company']; ?></div>
                            <p><?php echo $exp['description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>