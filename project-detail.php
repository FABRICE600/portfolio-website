<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = getProjectById($pdo, $id);

if (!$project) {
    redirect('projects.php');
}

$page_title = $project['title'] . " - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';
?>

<section class="project-detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-4"><?php echo $project['title']; ?></h1>
                <img src="assets/uploads/projects/<?php echo $project['image']; ?>" class="img-fluid rounded mb-4">
                <h3>Project Description</h3>
                <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                <h3>Technologies Used</h3>
                <?php 
                $techs = explode(',', $project['technologies']);
                foreach($techs as $tech): 
                ?>
                    <span class="badge bg-primary fs-6 me-2 mb-2 p-2"><?php echo trim($tech); ?></span>
                <?php endforeach; ?>
                <div class="mt-4">
                    <a href="<?php echo $project['github_link']; ?>" target="_blank" class="btn btn-dark btn-lg me-3">
                        <i class="fab fa-github me-2"></i>View on GitHub
                    </a>
                    <?php if($project['demo_link'] != '#' && $project['demo_link']): ?>
                        <a href="<?php echo $project['demo_link']; ?>" target="_blank" class="btn btn-primary btn-lg">
                            <i class="fas fa-external-link-alt me-2"></i>Live Demo
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>