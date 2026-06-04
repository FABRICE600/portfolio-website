<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$page_title = "Admin Dashboard";
$unread_count = getUnreadMessagesCount($pdo);

// Get statistics
$total_projects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$total_skills = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$total_blogs = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
$total_education = $pdo->query("SELECT COUNT(*) FROM education")->fetchColumn();
$total_experience = $pdo->query("SELECT COUNT(*) FROM experience")->fetchColumn();

// Get recent messages
$recent_messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
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
        .stat-card {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <div class="text-center py-4">
                    <h4 class="text-white">Admin Panel</h4>
                    <small class="text-white-50">Welcome, <?php echo $_SESSION['full_name']; ?></small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="projects.php" class="nav-link">
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
                            <?php if($unread_count > 0): ?>
                                <span class="badge bg-danger"><?php echo $unread_count; ?></span>
                            <?php endif; ?>
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
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">Dashboard Overview</h2>
                
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Projects</h5>
                                        <h2 class="mt-2"><?php echo $total_projects; ?></h2>
                                    </div>
                                    <i class="fas fa-project-diagram fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Skills</h5>
                                        <h2 class="mt-2"><?php echo $total_skills; ?></h2>
                                    </div>
                                    <i class="fas fa-code fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Messages</h5>
                                        <h2 class="mt-2"><?php echo $total_messages; ?></h2>
                                    </div>
                                    <i class="fas fa-envelope fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Blog Posts</h5>
                                        <h2 class="mt-2"><?php echo $total_blogs; ?></h2>
                                    </div>
                                    <i class="fas fa-blog fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Education & Experience</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Education:</strong> <?php echo $total_education; ?> entries</p>
                                <p><strong>Experience:</strong> <?php echo $total_experience; ?> entries</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Messages</h5>
                            </div>
                            <div class="card-body">
                                <?php if(count($recent_messages) > 0): ?>
                                    <div class="list-group">
                                        <?php foreach($recent_messages as $msg): ?>
                                            <div class="list-group-item">
                                                <strong><?php echo htmlspecialchars($msg['name']); ?></strong>
                                                <small class="text-muted"> - <?php echo formatDate($msg['created_at']); ?></small>
                                                <p class="mb-0 small"><?php echo truncateText($msg['message'], 50); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p>No messages yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>