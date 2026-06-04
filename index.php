<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "Home - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';

$user = getUserData($pdo);
$projects = getProjects($pdo, 3);
$blog_posts = getBlogPosts($pdo, 3);
$total_projects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$social_links = getSocialLinks($pdo);
?>

<!-- Hero Section -->
<section class="hero-section d-flex align-items-center" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; position: relative; overflow: hidden;">
    <!-- Background Pattern -->
    <div class="hero-bg-pattern" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><path fill=\"white\" d=\"M50,10 L60,30 L50,50 L40,30 Z\"/></svg>'); background-repeat: repeat; background-size: 40px;"></div>
    
    <div class="container text-center text-white position-relative z-index-2">
        <div data-aos="fade-down">
            <!-- Profile Image -->
            <div class="profile-wrapper mb-4">
                <div class="profile-border" style="width: 180px; height: 180px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); padding: 4px;">
                    <img src="assets/uploads/profile/<?php echo isset($user['profile_image']) ? $user['profile_image'] : 'default-avatar.png'; ?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                </div>
            </div>
            
            <!-- Animated Title -->
            <h1 class="display-3 fw-bold mb-3">
                <span class="typed-text"></span>
            </h1>
            
            <h2 class="mb-3" style="color: #4ecdc4;"><?php echo isset($user['full_name']) ? $user['full_name'] : 'Fabrice Umuhire'; ?></h2>
            
            <p class="lead mb-4" style="max-width: 600px; margin: 0 auto;">
                <i class="fas fa-map-marker-alt me-2"></i>Kigali, Rwanda | 
                <i class="fas fa-code me-2 ms-2"></i>Software Developer Student
            </p>
            
            <p class="mb-4"><?php echo isset($user['bio']) ? truncateText($user['bio'], 150) : 'Passionate software developer creating innovative solutions for the digital world.'; ?></p>
        </div>
        
        <!-- CTA Buttons -->
        <div class="d-flex justify-content-center gap-3 flex-wrap" data-aos="fade-up">
            <a href="projects.php" class="btn btn-light btn-lg px-4">
                <i class="fas fa-folder-open me-2"></i>View Projects
            </a>
            <a href="download-cv.php" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-download me-2"></i>Download CV
            </a>
            <a href="contact.php" class="btn btn-light btn-lg px-4">
                <i class="fas fa-envelope me-2"></i>Contact Me
            </a>
        </div>
        
        <!-- Social Links - All Platforms -->
        <div class="social-links mt-5" data-aos="fade-up">
            <?php if(is_array($social_links) && count($social_links) > 0): ?>
                <?php foreach($social_links as $link): ?>
                    <a href="<?php echo $link['url']; ?>" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0; transition: all 0.3s;" title="<?php echo $link['platform']; ?>">
                        <i class="<?php echo $link['icon_class']; ?> fs-4"></i>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default social links if none in database -->
                <a href="https://github.com/FABRICE600" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0;" title="GitHub">
                    <i class="fab fa-github fs-4"></i>
                </a>
                <a href="https://www.linkedin.com/in/umuhire-fabrice-437546410/" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0;" title="LinkedIn">
                    <i class="fab fa-linkedin fs-4"></i>
                </a>
                <a href="https://x.com/fabrice_u2007" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0;" title="Twitter">
                    <i class="fab fa-twitter fs-4"></i>
                </a>
                <a href="https://facebook.com/fabrice.umuhire" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0;" title="Facebook">
                    <i class="fab fa-facebook fs-4"></i>
                </a>
                <a href="https://instagram.com/fabrice_umuhire" target="_blank" class="btn btn-outline-light rounded-circle mx-2" style="width: 55px; height: 55px; line-height: 55px; padding: 0;" title="Instagram">
                    <i class="fab fa-instagram fs-4"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4" data-aos="fade-up">
        <a href="#skills-section" class="text-white">
            <i class="fas fa-chevron-down fa-2x animate-bounce"></i>
        </a>
    </div>
</section>

<!-- Skills Section -->
<section id="skills-section" class="skills-preview py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Technical <span style="color: #4ecdc4;">Skills</span></h2>
            <div class="divider mx-auto" style="width: 60px; height: 3px; background: linear-gradient(90deg, #ff6b6b, #4ecdc4); margin: 20px auto;"></div>
            <p class="lead">Technologies and tools I work with</p>
        </div>
        
        <div class="row">
            <?php 
            $skills = getSkillsByCategory($pdo, 'programming');
            $display_skills = is_array($skills) ? array_slice($skills, 0, 6) : [];
            foreach($display_skills as $skill): 
            ?>
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="skill-card p-4 bg-white rounded shadow-sm h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><?php echo $skill['skill_name']; ?></h5>
                            <span class="badge bg-primary rounded-pill"><?php echo $skill['percentage']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: <?php echo $skill['percentage']; ?>%; background: linear-gradient(90deg, #ff6b6b, #4ecdc4);"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-3" data-aos="fade-up">
            <a href="skills.php" class="btn btn-outline-primary">View All Skills <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="projects-preview py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Featured <span style="color: #ff6b6b;">Projects</span></h2>
            <div class="divider mx-auto" style="width: 60px; height: 3px; background: linear-gradient(90deg, #ff6b6b, #4ecdc4); margin: 20px auto;"></div>
            <p class="lead">Some of my best work</p>
        </div>
        
        <div class="row">
            <?php if(is_array($projects) && count($projects) > 0): ?>
                <?php foreach($projects as $project): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="project-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <img src="assets/uploads/projects/<?php echo $project['image']; ?>" class="card-img-top" alt="<?php echo $project['title']; ?>" style="height: 100%; width: 100%; object-fit: cover; transition: transform 0.3s;">
                                <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center opacity-0 transition" style="transition: opacity 0.3s;">
                                    <div class="text-center">
                                        <a href="project-detail.php?id=<?php echo $project['id']; ?>" class="btn btn-light btn-sm mx-1">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                        <a href="<?php echo $project['github_link']; ?>" target="_blank" class="btn btn-dark btn-sm mx-1">
                                            <i class="fab fa-github"></i> Code
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $project['title']; ?></h5>
                                <p class="card-text text-muted small"><?php echo truncateText($project['description'], 80); ?></p>
                                <div class="tech-tags mt-2">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    $display_techs = array_slice($techs, 0, 3);
                                    foreach($display_techs as $tech): 
                                    ?>
                                        <span class="badge bg-secondary me-1"><?php echo trim($tech); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No projects yet. Add some in the admin panel!
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="projects.php" class="btn btn-primary btn-lg px-5">
                View All Projects <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-section py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4" data-aos="fade-up">
                <div class="stat-card">
                    <i class="fas fa-code fa-3x mb-3" style="color: #4ecdc4;"></i>
                    <h2 class="display-4 fw-bold stat-number"><?php echo $total_projects; ?></h2>
                    <p class="mb-0">Projects Completed</p>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <i class="fas fa-user-graduate fa-3x mb-3" style="color: #ff6b6b;"></i>
                    <h2 class="display-4 fw-bold stat-number">3+</h2>
                    <p class="mb-0">Years Experience</p>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <i class="fas fa-smile fa-3x mb-3" style="color: #4ecdc4;"></i>
                    <h2 class="display-4 fw-bold stat-number"><?php echo $total_messages; ?></h2>
                    <p class="mb-0">Happy Clients</p>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <i class="fas fa-code-branch fa-3x mb-3" style="color: #ff6b6b;"></i>
                    <h2 class="display-4 fw-bold stat-number">50+</h2>
                    <p class="mb-0">GitHub Commits</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Section -->
<section class="blog-preview py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Latest <span style="color: #4ecdc4;">Blog Posts</span></h2>
            <div class="divider mx-auto" style="width: 60px; height: 3px; background: linear-gradient(90deg, #ff6b6b, #4ecdc4); margin: 20px auto;"></div>
            <p class="lead">Thoughts, ideas, and tutorials</p>
        </div>
        
        <div class="row">
            <?php if(is_array($blog_posts) && count($blog_posts) > 0): ?>
                <?php foreach($blog_posts as $post): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="blog-card card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge" style="background: #ff6b6b;"><?php echo $post['category']; ?></span>
                                    <small class="text-muted ms-2"><i class="far fa-calendar-alt me-1"></i><?php echo formatDate($post['created_at']); ?></small>
                                </div>
                                <h4 class="card-title mb-3"><?php echo $post['title']; ?></h4>
                                <p class="card-text text-muted"><?php echo truncateText($post['content'], 100); ?></p>
                                <a href="blog-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-link text-decoration-none p-0" style="color: #4ecdc4;">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No blog posts yet. Add some in the admin panel!
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="blog.php" class="btn btn-outline-primary btn-lg px-5">
                Read All Posts <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container text-center text-white" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">Let's Work Together!</h2>
        <p class="lead mb-4">Have a project in mind? I'd love to help bring your ideas to life.</p>
        <a href="contact.php" class="btn btn-light btn-lg px-5">
            <i class="fas fa-paper-plane me-2"></i>Get In Touch
        </a>
    </div>
</section>

<style>
    /* Custom animations */
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        60% {
            transform: translateY(-10px);
        }
    }
    
    .project-card:hover .project-overlay {
        opacity: 1 !important;
    }
    
    .project-card:hover img {
        transform: scale(1.1);
    }
    
    .transition {
        transition: all 0.3s ease;
    }
    
    /* Typing animation */
    .typed-text {
        border-right: 3px solid #4ecdc4;
        animation: blink 0.75s step-end infinite;
    }
    
    @keyframes blink {
        from, to { border-color: transparent; }
        50% { border-color: #4ecdc4; }
    }
    
    /* Social media button hover effects */
    .social-links .btn-outline-light:hover {
        transform: translateY(-5px) scale(1.1);
        background: white !important;
        color: #1a1a2e !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .display-5 {
            font-size: 1.8rem;
        }
        
        .stat-card {
            margin-bottom: 20px;
        }
        
        .social-links .btn-outline-light {
            width: 45px !important;
            height: 45px !important;
            line-height: 45px !important;
        }
        
        .social-links .btn-outline-light i {
            font-size: 1.2rem !important;
        }
    }
</style>

<script>
    // Typing animation for hero section
    document.addEventListener('DOMContentLoaded', function() {
        const typedElement = document.querySelector('.typed-text');
        if (typedElement) {
            const texts = [
                'Software Developer',
                'Web Developer', 
                'Problem Solver',
                'Tech Enthusiast',
                'Fabrice Umuhire'
            ];
            let textIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            
            function typeEffect() {
                const currentText = texts[textIndex];
                
                if (isDeleting) {
                    typedElement.textContent = currentText.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    typedElement.textContent = currentText.substring(0, charIndex + 1);
                    charIndex++;
                }
                
                if (!isDeleting && charIndex === currentText.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, 2000);
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                    setTimeout(typeEffect, 500);
                } else {
                    setTimeout(typeEffect, isDeleting ? 50 : 100);
                }
            }
            
            typeEffect();
        }
        
        // Counter animation for statistics
        const statNumbers = document.querySelectorAll('.stat-number');
        
        function animateNumbers() {
            statNumbers.forEach(num => {
                const target = parseInt(num.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        num.textContent = target;
                        clearInterval(timer);
                    } else {
                        num.textContent = Math.floor(current);
                    }
                }, 30);
            });
        }
        
        // Trigger counter when stats section is visible
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateNumbers();
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(statsSection);
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>