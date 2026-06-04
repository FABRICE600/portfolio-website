<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "My Projects - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';

$projects = getProjects($pdo);
?>

<section class="projects-section py-5">
    <div class="container">
        <h1 class="text-center mb-5">My Projects</h1>
        <div class="row">
            <?php if(is_array($projects) && count($projects) > 0): ?>
                <?php foreach($projects as $project): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card h-100 shadow-sm">
                            <img src="assets/uploads/projects/<?php echo $project['image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $project['title']; ?></h5>
                                <p class="card-text"><?php echo truncateText($project['description'], 100); ?></p>
                                <div class="tech-tags mb-3">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach($techs as $tech): 
                                    ?>
                                        <span class="badge bg-primary me-1"><?php echo trim($tech); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <a href="project-detail.php?id=<?php echo $project['id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No projects yet. Add some in the admin panel!</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>