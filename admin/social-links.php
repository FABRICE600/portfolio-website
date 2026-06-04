<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

// Handle add social link
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_social'])) {
    $platform = sanitize($_POST['platform']);
    $url = sanitize($_POST['url']);
    $icon_class = sanitize($_POST['icon_class']);
    
    $stmt = $pdo->prepare("INSERT INTO social_links (platform, url, icon_class) VALUES (?, ?, ?)");
    $stmt->execute([$platform, $url, $icon_class]);
    header('Location: social-links.php?success=added');
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_social'])) {
    $id = (int)$_POST['id'];
    $platform = sanitize($_POST['platform']);
    $url = sanitize($_POST['url']);
    $icon_class = sanitize($_POST['icon_class']);
    
    $stmt = $pdo->prepare("UPDATE social_links SET platform = ?, url = ?, icon_class = ? WHERE id = ?");
    $stmt->execute([$platform, $url, $icon_class, $id]);
    header('Location: social-links.php?success=updated');
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM social_links WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: social-links.php?success=deleted');
    exit();
}

// Get all social links
$social_links = getSocialLinks($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Social Links - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #34495e;
            padding-left: 30px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .social-preview {
            font-size: 2rem;
            transition: all 0.3s;
        }
        .social-preview:hover {
            transform: scale(1.2);
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
    <div class="sidebar">
        <div class="text-center py-4">
            <h4 class="text-white">Admin Panel</h4>
            <small class="text-white-50">Welcome, <?php echo $_SESSION['full_name']; ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
            <li class="nav-item"><a href="projects.php" class="nav-link"><i class="fas fa-project-diagram me-2"></i>Projects</a></li>
            <li class="nav-item"><a href="skills.php" class="nav-link"><i class="fas fa-code me-2"></i>Skills</a></li>
            <li class="nav-item"><a href="social-links.php" class="nav-link active"><i class="fas fa-share-alt me-2"></i>Social Links</a></li>
            <li class="nav-item"><a href="messages.php" class="nav-link"><i class="fas fa-envelope me-2"></i>Messages</a></li>
            <li class="nav-item"><a href="blog.php" class="nav-link"><i class="fas fa-blog me-2"></i>Blog</a></li>
            <li class="nav-item"><a href="profile.php" class="nav-link"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li class="nav-item mt-4"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-share-alt me-2"></i>Manage Social Links</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Add Social Link
                </button>
            </div>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php 
                        if($_GET['success'] == 'added') echo 'Social link added successfully!';
                        if($_GET['success'] == 'updated') echo 'Social link updated successfully!';
                        if($_GET['success'] == 'deleted') echo 'Social link deleted successfully!';
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5>Your Social Media Links</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Platform</th>
                                    <th>URL</th>
                                    <th>Icon Class</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($social_links as $link): ?>
                                <tr>
                                    <td><i class="<?php echo $link['icon_class']; ?> fa-2x social-preview"></i></td>
                                    <td><strong><?php echo $link['platform']; ?></strong></td>
                                    <td><a href="<?php echo $link['url']; ?>" target="_blank"><?php echo substr($link['url'], 0, 40); ?>...</a></td>
                                    <td><code><?php echo $link['icon_class']; ?></code></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editSocial(<?php echo $link['id']; ?>, '<?php echo $link['platform']; ?>', '<?php echo $link['url']; ?>', '<?php echo $link['icon_class']; ?>')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <a href="?delete=<?php echo $link['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this social link?')">
                                            <i class="fas fa-trash"></i> Delete
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Social Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Platform Name</label>
                            <input type="text" name="platform" class="form-control" placeholder="e.g., Facebook, Instagram" required>
                        </div>
                        <div class="mb-3">
                            <label>URL</label>
                            <input type="url" name="url" class="form-control" placeholder="https://..." required>
                        </div>
                        <div class="mb-3">
                            <label>Icon Class</label>
                            <select name="icon_class" class="form-select" required>
                                <option value="fab fa-github">GitHub (fab fa-github)</option>
                                <option value="fab fa-linkedin">LinkedIn (fab fa-linkedin)</option>
                                <option value="fab fa-twitter">Twitter/X (fab fa-twitter)</option>
                                <option value="fab fa-facebook">Facebook (fab fa-facebook)</option>
                                <option value="fab fa-instagram">Instagram (fab fa-instagram)</option>
                                <option value="fab fa-youtube">YouTube (fab fa-youtube)</option>
                                <option value="fab fa-tiktok">TikTok (fab fa-tiktok)</option>
                                <option value="fab fa-discord">Discord (fab fa-discord)</option>
                                <option value="fab fa-whatsapp">WhatsApp (fab fa-whatsapp)</option>
                                <option value="fab fa-telegram">Telegram (fab fa-telegram)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_social" class="btn btn-primary">Add Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Social Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Platform Name</label>
                            <input type="text" name="platform" id="edit_platform" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>URL</label>
                            <input type="url" name="url" id="edit_url" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Icon Class</label>
                            <select name="icon_class" id="edit_icon" class="form-select" required>
                                <option value="fab fa-github">GitHub (fab fa-github)</option>
                                <option value="fab fa-linkedin">LinkedIn (fab fa-linkedin)</option>
                                <option value="fab fa-twitter">Twitter/X (fab fa-twitter)</option>
                                <option value="fab fa-facebook">Facebook (fab fa-facebook)</option>
                                <option value="fab fa-instagram">Instagram (fab fa-instagram)</option>
                                <option value="fab fa-youtube">YouTube (fab fa-youtube)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_social" class="btn btn-primary">Update Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editSocial(id, platform, url, iconClass) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_platform').value = platform;
            document.getElementById('edit_url').value = url;
            document.getElementById('edit_icon').value = iconClass;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
</body>
</html>