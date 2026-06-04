<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);
    $category = sanitize($_POST['category']);
    
    $image = 'default-blog.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], BLOG_UPLOAD_DIR);
        if ($uploaded) {
            $image = $uploaded;
        }
    }
    
    $stmt = $pdo->prepare("INSERT INTO blog_posts (title, content, category, image) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$title, $content, $category, $image])) {
        header('Location: blog.php?success=added');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Add New Blog Post</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="Tutorial">Tutorial</option>
                                    <option value="Learning Experience">Learning Experience</option>
                                    <option value="Project Update">Project Update</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Content</label>
                                <textarea name="content" class="form-control" rows="10" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Featured Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Publish Post</button>
                            <a href="blog.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>