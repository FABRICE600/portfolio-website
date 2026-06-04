<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$id = (int)$_GET['id'];
$skill = getSkillById($pdo, $id);

if (!$skill) {
    header('Location: skills.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_name = sanitize($_POST['skill_name']);
    $category = sanitize($_POST['category']);
    $percentage = (int)$_POST['percentage'];
    
    $stmt = $pdo->prepare("UPDATE skills SET skill_name = ?, category = ?, percentage = ? WHERE id = ?");
    
    if ($stmt->execute([$skill_name, $category, $percentage, $id])) {
        header('Location: skills.php?success=updated');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Skill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Skill</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label>Skill Name</label>
                                <input type="text" name="skill_name" class="form-control" value="<?php echo $skill['skill_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="programming" <?php echo $skill['category'] == 'programming' ? 'selected' : ''; ?>>Programming</option>
                                    <option value="framework" <?php echo $skill['category'] == 'framework' ? 'selected' : ''; ?>>Framework</option>
                                    <option value="tool" <?php echo $skill['category'] == 'tool' ? 'selected' : ''; ?>>Tool</option>
                                    <option value="soft" <?php echo $skill['category'] == 'soft' ? 'selected' : ''; ?>>Soft Skills</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Percentage (0-100)</label>
                                <input type="number" name="percentage" min="0" max="100" class="form-control" value="<?php echo $skill['percentage']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Skill</button>
                            <a href="skills.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>