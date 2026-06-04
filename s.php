<?php
// First require config
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "My Skills - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';

$grouped_skills = getAllSkillsGrouped($pdo);
?>

<section class="skills-section py-5">
    <div class="container">
        <h1 class="text-center mb-5" data-aos="fade-up">Technical Skills</h1>
        
        <?php if(is_array($grouped_skills) && count($grouped_skills) > 0): ?>
            <?php foreach($grouped_skills as $category => $skills): ?>
                <div class="category-box mb-5" data-aos="fade-up">
                    <h2 class="mb-4 text-capitalize">
                        <i class="fas 
                            <?php 
                            echo $category == 'programming' ? 'fa-code' : 
                                ($category == 'framework' ? 'fa-layer-group' : 
                                ($category == 'tool' ? 'fa-tools' : 'fa-users')); 
                            ?>
                        me-2"></i>
                        <?php echo ucfirst($category); ?> Skills
                    </h2>
                    <div class="row">
                        <?php foreach($skills as $skill): ?>
                            <div class="col-md-6 mb-4">
                                <div class="skill-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong><?php echo $skill['skill_name']; ?></strong>
                                        <span><?php echo $skill['percentage']; ?>%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php echo $skill['percentage']; ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center">
                <p>No skills added yet. Add some in the admin panel!</p>
            </div>
        <?php endif; ?>
        
        <div class="soft-skills mt-5" data-aos="fade-up">
            <h2 class="text-center mb-4">Soft Skills</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="soft-skill-card p-3 border rounded">
                        <i class="fas fa-lightbulb fa-3x mb-3 text-primary"></i>
                        <h5>Problem Solving</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="soft-skill-card p-3 border rounded">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h5>Team Work</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="soft-skill-card p-3 border rounded">
                        <i class="fas fa-comments fa-3x mb-3 text-primary"></i>
                        <h5>Communication</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="soft-skill-card p-3 border rounded">
                        <i class="fas fa-clock fa-3x mb-3 text-primary"></i>
                        <h5>Time Management</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>