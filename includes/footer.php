    </main>

    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-code me-2"></i><?php echo SITE_NAME; ?></h5>
                    <p>Building amazing web applications and solving real-world problems through code. Based in Kigali, Rwanda.</p>
                    <div class="mt-3">
                        <p class="mb-1 small">
                            <i class="fas fa-envelope me-2"></i>fabrice@portfolio.com
                        </p>
                        <p class="mb-0 small">
                            <i class="fas fa-map-marker-alt me-2"></i>Kigali, Rwanda
                        </p>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                        <li class="mb-2"><a href="about.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>About</a></li>
                        <li class="mb-2"><a href="projects.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Projects</a></li>
                        <li class="mb-2"><a href="skills.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Skills</a></li>
                        <li class="mb-2"><a href="blog.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Blog</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Contact</a></li>
                    </ul>
                </div>
                
                <!-- Social Links Section -->
                <div class="col-md-4 mb-4">
                    <h5>Connect With Me</h5>
                    <div class="social-links mb-3">
                        <?php if(isset($social_links) && is_array($social_links) && count($social_links) > 0): ?>
                            <?php foreach($social_links as $link): ?>
                                <a href="<?php echo $link['url']; ?>" target="_blank" class="text-white me-3 fs-3" title="<?php echo $link['platform']; ?>">
                                    <i class="<?php echo $link['icon_class']; ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Default social links -->
                            <a href="https://github.com/FABRICE600" target="_blank" class="text-white me-3 fs-3" title="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/umuhire-fabrice-437546410/" target="_blank" class="text-white me-3 fs-3" title="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="https://x.com/fabrice_u2007" target="_blank" class="text-white me-3 fs-3" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://facebook.com/fabrice.umuhire" target="_blank" class="text-white me-3 fs-3" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://instagram.com/fabrice_umuhire" target="_blank" class="text-white me-3 fs-3" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="mt-3">
                        <p class="mb-2 small">
                            <i class="fas fa-envelope me-2"></i>umuhirefabrice24@gmail.com
                        </p>
                        <p class="mb-0 small">
                            <i class="fas fa-phone me-2"></i>+250 792752832
                        </p>
                    </div>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            
            <!-- Copyright -->
            <div class="text-center">
                <p class="mb-0 small">
                    &copy; <?php echo date('Y'); ?> <?php echo isset($user['full_name']) ? $user['full_name'] : 'Fabrice Umuhire'; ?>. All rights reserved.
                </p>
                <p class="mb-0 small text-white-50 mt-2">
                    <i class="fas fa-code me-1"></i> Built with <i class="fas fa-heart text-danger mx-1"></i> in Rwanda
                </p>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Button -->
    <button id="darkModeToggle" class="dark-mode-toggle">
        <i class="fas fa-moon"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
            darkModeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                const isDark = document.body.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isDark);
                darkModeToggle.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            });
        }
        
        // Scroll to Top Button
        const scrollTop = document.createElement('button');
        scrollTop.className = 'scroll-top';
        scrollTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
        document.body.appendChild(scrollTop);
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTop.classList.add('show');
            } else {
                scrollTop.classList.remove('show');
            }
        });
        
        scrollTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>