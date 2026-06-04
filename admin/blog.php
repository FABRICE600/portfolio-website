<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$blog_posts = getBlogPosts($pdo);

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: blog.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Manage Blog Posts</h2>
            <a href="add-blog.php" class="btn btn-primary">Add New Post</a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>ID</th><th>Title</th><th>Category</th><th>Views</th><th>Created</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($blog_posts as $post): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo $post['title']; ?></td>
                            <td><?php echo $post['category']; ?></td>
                            <td><?php echo $post['views']; ?></td>
                            <td><?php echo formatDate($post['created_at']); ?></td>
                            <td>
                                <a href="edit-blog.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?delete=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>