<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "Contact Me - " . SITE_NAME;
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $subject, $message])) {
            $success = true;
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
$user = getUserData($pdo);
?>

<section class="contact-section py-5">
    <div class="container">
        <h1 class="text-center mb-5">Get In Touch</h1>
        
        <?php if($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Thank you for your message! I'll get back to you soon.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-5 mb-4" data-aos="fade-right">
                <div class="contact-info p-4 bg-light rounded">
                    <h3 class="mb-4">Contact Information</h3>
                    <div class="info-item mb-3 d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x text-primary me-3"></i>
                        <div><h5 class="mb-0">Email</h5><p><?php echo isset($user['email']) ? $user['email'] : 'admin@portfolio.com'; ?></p></div>
                    </div>
                    <div class="info-item mb-3 d-flex align-items-center">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-3"></i>
                        <div><h5 class="mb-0">Location</h5><p>Kigali, Rwanda</p></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7" data-aos="fade-left">
                <form method="POST" class="contact-form p-4 bg-light rounded">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-paper-plane me-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>