<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$projects = getProjects($pdo);
$message = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $project = getProjectById($pdo, $id);
    
    if ($project) {
        // Delete project image
        $image_path = PROJECT_UPLOAD_DIR . $project['image'];
        if ($project['image'] != 'default-project.jpg' && file_exists($image_path)) {
            deleteFile($image_path);
        }
        
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        if ($stmt->execute([$id])) {
            $message = '<div class="alert alert-success">Project deleted successfully!</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 p-0 bg-dark min-vh-100">
                <div class="text-center py-4">
                    <h4 class="text-white">Admin Panel</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="projects.php" class="nav-link text-white active bg-primary">Projects</a></li>
                    <li class="nav-item"><a href="skills.php" class="nav-link text-white">Skills</a></li>
                    <li class="nav-item"><a href="messages.php" class="nav-link text-white">Messages</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link text-white">Blog</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
                </ul>
            </div>
            
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Manage Projects</h2>
                    <a href="add-project.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Project
                    </a>
                </div>
                
                <?php echo $message; ?>
                
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($projects as $project): ?>
                                <tr>
                                    <td><?php echo $project['id']; ?></td>
                                    <td>
                                        <img src="../assets/uploads/projects/<?php echo $project['image']; ?>" width="50" height="50" style="object-fit: cover;">
                                    </td>
                                    <td><?php echo $project['title']; ?></td>
                                    <td><?php echo $project['category']; ?></td>
                                    <td><?php echo formatDate($project['created_at']); ?></td>
                                    <td>
                                        <a href="edit-project.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>