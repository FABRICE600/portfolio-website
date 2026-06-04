<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = getBlogById($pdo, $id);

if (!$post) {
    redirect('blog.php');
}

incrementBlogViews($pdo, $id);

$page_title = $post['title'] . " - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';
?>

<section class="blog-detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-3"><?php echo $post['title']; ?></h1>
                <div class="blog-meta text-muted mb-4">
                    <span><i class="far fa-calendar-alt me-1"></i><?php echo formatDate($post['created_at']); ?></span>
                    <span class="ms-3"><i class="far fa-folder me-1"></i><?php echo $post['category']; ?></span>
                    <span class="ms-3"><i class="far fa-eye me-1"></i><?php echo $post['views']; ?> views</span>
                </div>
                <div class="blog-content">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>
                <div class="mt-5">
                    <a href="blog.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Back to Blog</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>