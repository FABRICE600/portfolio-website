<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_experience'])) {
    $position = sanitize($_POST['position']);
    $company = sanitize($_POST['company']);
    $year_start = (int)$_POST['year_start'];
    $year_end = $_POST['year_end'] ? (int)$_POST['year_end'] : null;
    $description = sanitize($_POST['description']);
    
    $stmt = $pdo->prepare("INSERT INTO experience (position, company, year_start, year_end, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$position, $company, $year_start, $year_end, $description]);
    header('Location: experience.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM experience WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: experience.php');
    exit();
}

$experience = getExperience($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Manage Experience</h2>
        
        <!-- Add Experience Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Add New Experience</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Position</label>
                            <input type="text" name="position" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control" required>
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
                    <button type="submit" name="add_experience" class="btn btn-primary">Add Experience</button>
                </form>
            </div>
        </div>
        
        <!-- Experience List -->
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>Position</th><th>Company</th><th>Year</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($experience as $exp): ?>
                        <tr>
                            <td><?php echo $exp['position']; ?></td>
                            <td><?php echo $exp['company']; ?></td>
                            <td><?php echo $exp['year_start']; ?> - <?php echo $exp['year_end'] ?? 'Present'; ?></td>
                            <td>
                                <a href="?delete=<?php echo $exp['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
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