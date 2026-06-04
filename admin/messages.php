<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

// Mark all as read
$pdo->exec("UPDATE messages SET is_read = 1");

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: messages.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Contact Messages</h2>
        
        <div class="card">
            <div class="card-body">
                <?php foreach($messages as $msg): ?>
                    <div class="message-item border-bottom mb-3 pb-3">
                        <div class="d-flex justify-content-between">
                            <h5><?php echo htmlspecialchars($msg['name']); ?></h5>
                            <small class="text-muted"><?php echo formatDate($msg['created_at']); ?></small>
                        </div>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                        <?php if($msg['subject']): ?>
                            <p><strong>Subject:</strong> <?php echo htmlspecialchars($msg['subject']); ?></p>
                        <?php endif; ?>
                        <p><strong>Message:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        <a href="?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                    </div>
                <?php endforeach; ?>
                
                <?php if(count($messages) == 0): ?>
                    <p class="text-center">No messages yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>