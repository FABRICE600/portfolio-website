<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_education'])) {
    $degree = sanitize($_POST['degree']);
    $institution = sanitize($_POST['institution']);
    $year_start = (int)$_POST['year_start'];
    $year_end = $_POST['year_end'] ? (int)$_POST['year_end'] : null;
    $description = sanitize($_POST['description']);
    
    $stmt = $pdo->prepare("INSERT INTO education (degree, institution, year_start, year_end, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$degree, $institution, $year_start, $year_end, $description]);
    header('Location: education.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM education WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: education.php');
    exit();
}

$education = getEducation($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Education</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Manage Education</h2>
        
        <!-- Add Education Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Add New Education</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Degree</label>
                            <input type="text" name="degree" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Institution</label>
                            <input type="text" name="institution" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Start Year</label>
                            <input type="number" name="year_start" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>End Year</label>
                            <input type="number" name="year_end" class="form-control" placeholder="Present">
                        </div>
                        <div class="col-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" name="add_education" class="btn btn-primary">Add Education</button>
                </form>
            </div>
        </div>
        
        <!-- Education List -->
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>Degree</th><th>Institution</th><th>Year</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($education as $edu): ?>
                        <tr>
                            <td><?php echo $edu['degree']; ?></td>
                            <td><?php echo $edu['institution']; ?></td>
                            <td><?php echo $edu['year_start']; ?> - <?php echo $edu['year_end'] ?? 'Present'; ?></td>
                            <td>
                                <a href="?delete=<?php echo $edu['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
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