<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $technologies = sanitize($_POST['technologies']);
    $category = sanitize($_POST['category']);
    $github_link = sanitize($_POST['github_link']);
    $demo_link = sanitize($_POST['demo_link']);
    
    $image = 'default-project.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], PROJECT_UPLOAD_DIR);
        if ($uploaded) {
            $image = $uploaded;
        }
    }
    
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, technologies, category, image, github_link, demo_link) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$title, $description, $technologies, $category, $image, $github_link, $demo_link])) {
        header('Location: projects.php?success=added');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Add New Project</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Technologies (comma separated)</label>
                                <input type="text" name="technologies" class="form-control" placeholder="PHP, MySQL, Bootstrap" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="web">Web Development</option>
                                    <option value="fullstack">Full Stack</option>
                                    <option value="backend">Backend</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>GitHub Link</label>
                                <input type="url" name="github_link" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Demo Link</label>
                                <input type="url" name="demo_link" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Project Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Project</button>
                            <a href="projects.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>