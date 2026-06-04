<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = "Blog - " . SITE_NAME;
require_once __DIR__ . '/includes/header.php';

$blog_posts = getBlogPosts($pdo);
?>

<section class="blog-section py-5">
    <div class="container">
        <h1 class="text-center mb-5">My Blog</h1>
        <div class="row">
            <?php if(is_array($blog_posts) && count($blog_posts) > 0): ?>
                <?php foreach($blog_posts as $post): ?>
                    <div class="col-md-6 mb-4" data-aos="fade-up">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge bg-primary"><?php echo $post['category']; ?></span>
                                    <span class="text-muted ms-2"><i class="far fa-calendar-alt me-1"></i><?php echo formatDate($post['created_at']); ?></span>
                                    <span class="text-muted ms-2"><i class="far fa-eye me-1"></i><?php echo $post['views']; ?> views</span>
                                </div>
                                <h3 class="card-title"><?php echo $post['title']; ?></h3>
                                <p class="card-text"><?php echo truncateText($post['content'], 150); ?></p>
                                <a href="blog-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary">Read More →</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No blog posts yet. Add some in the admin panel!</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>