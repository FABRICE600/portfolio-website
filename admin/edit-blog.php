<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$id = (int)$_GET['id'];
$post = getBlogById($pdo, $id);

if (!$post) {
    header('Location: blog.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);
    $category = sanitize($_POST['category']);
    
    $image = $post['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], BLOG_UPLOAD_DIR);
        if ($uploaded) {
            if ($post['image'] != 'default-blog.jpg') {
                deleteFile(BLOG_UPLOAD_DIR . $post['image']);
            }
            $image = $uploaded;
        }
    }
    
    $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, content = ?, category = ?, image = ? WHERE id = ?");
    
    if ($stmt->execute([$title, $content, $category, $image, $id])) {
        header('Location: blog.php?success=updated');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Blog Post</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="Tutorial" <?php echo $post['category'] == 'Tutorial' ? 'selected' : ''; ?>>Tutorial</option>
                                    <option value="Learning Experience" <?php echo $post['category'] == 'Learning Experience' ? 'selected' : ''; ?>>Learning Experience</option>
                                    <option value="Project Update" <?php echo $post['category'] == 'Project Update' ? 'selected' : ''; ?>>Project Update</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Content</label>
                                <textarea name="content" class="form-control" rows="10" required><?php echo $post['content']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Current Image</label>
                                <img src="../assets/uploads/blog/<?php echo $post['image']; ?>" width="100" class="d-block mb-2">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="blog.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>