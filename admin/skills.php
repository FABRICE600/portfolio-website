<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$skills = $pdo->query("SELECT * FROM skills ORDER BY category, percentage DESC")->fetchAll();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: skills.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Manage Skills</h2>
            <a href="add-skill.php" class="btn btn-primary">Add New Skill</a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>ID</th><th>Skill</th><th>Category</th><th>Percentage</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($skills as $skill): ?>
                        <tr>
                            <td><?php echo $skill['id']; ?></td>
                            <td><?php echo $skill['skill_name']; ?></td>
                            <td><?php echo $skill['category']; ?></td>
                            <td><?php echo $skill['percentage']; ?>%</td>
                            <td>
                                <a href="edit-skill.php?id=<?php echo $skill['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?delete=<?php echo $skill['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this skill?')">Delete</a>
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