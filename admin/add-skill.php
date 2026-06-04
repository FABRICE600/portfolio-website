<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_name = sanitize($_POST['skill_name']);
    $category = sanitize($_POST['category']);
    $percentage = (int)$_POST['percentage'];
    
    $stmt = $pdo->prepare("INSERT INTO skills (skill_name, category, percentage) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$skill_name, $category, $percentage])) {
        header('Location: skills.php?success=added');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Add New Skill</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label>Skill Name</label>
                                <input type="text" name="skill_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="programming">Programming</option>
                                    <option value="framework">Framework</option>
                                    <option value="tool">Tool</option>
                                    <option value="soft">Soft Skills</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Percentage (0-100)</label>
                                <input type="number" name="percentage" min="0" max="100" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Skill</button>
                            <a href="skills.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>