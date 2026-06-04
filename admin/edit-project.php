<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = getProjectById($pdo, $id);

if (!$project) {
    redirect('projects.php');
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $technologies = sanitize($_POST['technologies']);
    $category = sanitize($_POST['category']);
    $github_link = sanitize($_POST['github_link']);
    $demo_link = sanitize($_POST['demo_link']);
    
    $image = $project['image'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], PROJECT_UPLOAD_DIR);
        if ($uploaded) {
            // Delete old image if not default
            if ($project['image'] != 'default-project.jpg' && file_exists(PROJECT_UPLOAD_DIR . $project['image'])) {
                deleteFile(PROJECT_UPLOAD_DIR . $project['image']);
            }
            $image = $uploaded;
            $success = 'Project updated successfully with new image!';
        } else {
            $error = 'Failed to upload image. Please check file type (JPEG, PNG, GIF) and size (max 5MB).';
        }
    }
    
    if (empty($error)) {
        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, technologies = ?, category = ?, image = ?, github_link = ?, demo_link = ? WHERE id = ?");
        
        if ($stmt->execute([$title, $description, $technologies, $category, $image, $github_link, $demo_link, $id])) {
            $success = 'Project updated successfully!';
            // Refresh project data
            $project = getProjectById($pdo, $id);
        } else {
            $error = 'Failed to update project. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
        }
        .sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #34495e;
            padding-left: 30px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        }
        .current-image {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }
        .current-image img {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        .current-image img:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-save {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40,167,69,0.3);
        }
        .btn-cancel {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 10px;
            animation: slideDown 0.5s ease;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .preview-image {
            max-width: 200px;
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center py-4">
            <h4 class="text-white">Admin Panel</h4>
            <small class="text-white-50">Welcome, <?php echo $_SESSION['full_name']; ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="projects.php" class="nav-link active">
                    <i class="fas fa-project-diagram me-2"></i>Projects
                </a>
            </li>
            <li class="nav-item">
                <a href="skills.php" class="nav-link">
                    <i class="fas fa-code me-2"></i>Skills
                </a>
            </li>
            <li class="nav-item">
                <a href="education.php" class="nav-link">
                    <i class="fas fa-graduation-cap me-2"></i>Education
                </a>
            </li>
            <li class="nav-item">
                <a href="experience.php" class="nav-link">
                    <i class="fas fa-briefcase me-2"></i>Experience
                </a>
            </li>
            <li class="nav-item">
                <a href="messages.php" class="nav-link">
                    <i class="fas fa-envelope me-2"></i>Messages
                </a>
            </li>
            <li class="nav-item">
                <a href="blog.php" class="nav-link">
                    <i class="fas fa-blog me-2"></i>Blog Posts
                </a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link">
                    <i class="fas fa-user me-2"></i>Profile
                </a>
            </li>
            <li class="nav-item mt-4">
                <a href="logout.php" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-edit me-2"></i>Edit Project</h2>
                <a href="projects.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Projects
                </a>
            </div>

            <!-- Success/Error Messages -->
            <?php if($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Edit Form -->
            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Project Title *</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" rows="6" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                            <small class="text-muted">Detailed description of your project</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Technologies *</label>
                            <input type="text" name="technologies" class="form-control" value="<?php echo htmlspecialchars($project['technologies']); ?>" placeholder="PHP, MySQL, Bootstrap, JavaScript" required>
                            <small class="text-muted">Separate technologies with commas</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category" class="form-select" required>
                                <option value="web" <?php echo $project['category'] == 'web' ? 'selected' : ''; ?>>Web Development</option>
                                <option value="fullstack" <?php echo $project['category'] == 'fullstack' ? 'selected' : ''; ?>>Full Stack</option>
                                <option value="backend" <?php echo $project['category'] == 'backend' ? 'selected' : ''; ?>>Backend</option>
                                <option value="frontend" <?php echo $project['category'] == 'frontend' ? 'selected' : ''; ?>>Frontend</option>
                                <option value="mobile" <?php echo $project['category'] == 'mobile' ? 'selected' : ''; ?>>Mobile App</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">GitHub Link</label>
                            <input type="url" name="github_link" class="form-control" value="<?php echo htmlspecialchars($project['github_link']); ?>" placeholder="https://github.com/username/project">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Live Demo Link</label>
                            <input type="url" name="demo_link" class="form-control" value="<?php echo htmlspecialchars($project['demo_link']); ?>" placeholder="https://yourproject.com">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Current Image</label>
                            <div class="current-image">
                                <img src="../assets/uploads/projects/<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" class="preview-image">
                                <div class="mt-2">
                                    <small class="text-muted">Current: <?php echo $project['image']; ?></small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Change Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="text-muted">Max size: 5MB. Allowed: JPEG, PNG, JPG, GIF</small>
                        </div>
                        
                        <div class="col-md-12 text-center mt-4">
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <a href="projects.php" class="btn btn-cancel ms-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Preview Card -->
            <div class="form-container mt-4">
                <h5><i class="fas fa-eye me-2"></i>Live Preview</h5>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <img src="../assets/uploads/projects/<?php echo $project['image']; ?>" class="card-img-top" alt="<?php echo $project['title']; ?>" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $project['title']; ?></h5>
                                <p class="card-text small"><?php echo truncateText($project['description'], 80); ?></p>
                                <div class="tech-tags">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach(array_slice($techs, 0, 3) as $tech): 
                                    ?>
                                        <span class="badge bg-primary me-1"><?php echo trim($tech); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Preview Note:</strong> This is how your project will appear on the website. Make changes above and save to update.
                        </div>
                        <div class="mt-3">
                            <h6>Current Details:</h6>
                            <ul>
                                <li><strong>Title:</strong> <?php echo $project['title']; ?></li>
                                <li><strong>Category:</strong> <?php echo ucfirst($project['category']); ?></li>
                                <li><strong>Technologies:</strong> <?php echo $project['technologies']; ?></li>
                                <li><strong>GitHub:</strong> <?php echo $project['github_link'] ? '<a href="'.$project['github_link'].'" target="_blank">View on GitHub</a>' : 'Not provided'; ?></li>
                                <li><strong>Demo:</strong> <?php echo $project['demo_link'] ? '<a href="'.$project['demo_link'].'" target="_blank">View Live Demo</a>' : 'Not provided'; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview
        document.querySelector('input[name="image"]').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.preview-image');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const title = document.querySelector('input[name="title"]').value;
            const description = document.querySelector('textarea[name="description"]').value;
            const technologies = document.querySelector('input[name="technologies"]').value;
            
            if (!title || !description || !technologies) {
                e.preventDefault();
                alert('Please fill in all required fields (Title, Description, Technologies)');
            }
        });
    </script>
</body>
</html>