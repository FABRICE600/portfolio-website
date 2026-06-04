<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$user = getUserData($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $title = sanitize($_POST['title']);
    $bio = sanitize($_POST['bio']);
    
    $update_sql = "UPDATE users SET full_name = ?, email = ?, title = ?, bio = ?";
    $params = [$full_name, $email, $title, $bio];
    
    // Handle profile image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['profile_image'], PROFILE_UPLOAD_DIR);
        if ($uploaded) {
            // Delete old image if not default
            if ($user['profile_image'] != 'default-avatar.png') {
                deleteFile(PROFILE_UPLOAD_DIR . $user['profile_image']);
            }
            $update_sql .= ", profile_image = ?";
            $params[] = $uploaded;
        }
    }
    
    // Handle CV upload
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == 0) {
        $cv_name = time() . '_' . basename($_FILES['cv_file']['name']);
        $cv_path = UPLOAD_DIR . 'cv/' . $cv_name;
        
        if (!file_exists(UPLOAD_DIR . 'cv/')) {
            mkdir(UPLOAD_DIR . 'cv/', 0777, true);
        }
        
        if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $cv_path)) {
            if ($user['cv_file'] != 'cv.pdf' && file_exists(UPLOAD_DIR . 'cv/' . $user['cv_file'])) {
                deleteFile(UPLOAD_DIR . 'cv/' . $user['cv_file']);
            }
            $update_sql .= ", cv_file = ?";
            $params[] = $cv_name;
        }
    }
    
    $update_sql .= " WHERE id = ?";
    $params[] = $user['id'];
    
    $stmt = $pdo->prepare($update_sql);
    if ($stmt->execute($params)) {
        $message = '<div class="alert alert-success">Profile updated successfully!</div>';
        $user = getUserData($pdo);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $message; ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <img src="../assets/uploads/profile/<?php echo $user['profile_image']; ?>" 
                                     width="150" height="150" class="rounded-circle" style="object-fit: cover;">
                            </div>
                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Professional Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $user['title']; ?>">
                            </div>
                            <div class="mb-3">
                                <label>Bio</label>
                                <textarea name="bio" class="form-control" rows="5"><?php echo $user['bio']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Profile Image</label>
                                <input type="file" name="profile_image" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label>CV (PDF)</label>
                                <input type="file" name="cv_file" class="form-control" accept=".pdf">
                                <small class="text-muted">Current: <?php echo $user['cv_file']; ?></small>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>