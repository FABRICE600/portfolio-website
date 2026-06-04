<?php
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function uploadImage($file, $targetDir) {
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $targetDir . $fileName;
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    if (in_array($file['type'], $allowedTypes) && $file['size'] < 5000000) {
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }
    }
    return false;
}

function deleteFile($filePath) {
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

function getProjectById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getSkillById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getBlogById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function truncateText($text, $length = 100) {
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...';
    }
    return $text;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('admin/login.php');
    }
}

function getProjects($pdo, $limit = null) {
    $sql = "SELECT * FROM projects ORDER BY created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getSkillsByCategory($pdo, $category) {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE category = ? ORDER BY percentage DESC");
    $stmt->execute([$category]);
    return $stmt->fetchAll();
}

function getAllSkillsGrouped($pdo) {
    $stmt = $pdo->query("SELECT * FROM skills ORDER BY category, percentage DESC");
    $skills = $stmt->fetchAll();
    $grouped = [];
    foreach ($skills as $skill) {
        $grouped[$skill['category']][] = $skill;
    }
    return $grouped;
}

function getEducation($pdo) {
    $stmt = $pdo->query("SELECT * FROM education ORDER BY year_start DESC");
    return $stmt->fetchAll();
}

function getExperience($pdo) {
    $stmt = $pdo->query("SELECT * FROM experience ORDER BY year_start DESC");
    return $stmt->fetchAll();
}

function getBlogPosts($pdo, $limit = null) {
    $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function incrementBlogViews($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
    $stmt->execute([$id]);
}
?>