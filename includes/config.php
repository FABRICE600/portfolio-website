<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Site Configuration
define('SITE_NAME', 'Fabrice Umuhire Portfolio');
define('SITE_URL', 'http://mycinemagic1.lovestoblog.com/');
define('ADMIN_EMAIL', 'fabrice@portfolio.com');

// ============================================
// DATABASE CONFIGURATION - USING IP ADDRESS
// ============================================
define('DB_HOST', '185.27.134.11');  // Using IP instead of hostname
define('DB_NAME', 'if0_41982877_portfolio_db');
define('DB_USER', 'if0_41982877');
define('DB_PASS', 'umuhire2007');

// Root path
define('ROOT_PATH', dirname(__DIR__));

// Upload directories
define('UPLOAD_DIR', ROOT_PATH . '/assets/uploads/');
define('PROJECT_UPLOAD_DIR', UPLOAD_DIR . 'projects/');
define('BLOG_UPLOAD_DIR', UPLOAD_DIR . 'blog/');
define('PROFILE_UPLOAD_DIR', UPLOAD_DIR . 'profile/');

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create directories
$dirs = [PROJECT_UPLOAD_DIR, BLOG_UPLOAD_DIR, PROFILE_UPLOAD_DIR, UPLOAD_DIR . 'cv/'];
foreach($dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Helper functions
function getUserData($pdo) {
    $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
    return $stmt->fetch();
}

function getSocialLinks($pdo) {
    $stmt = $pdo->query("SELECT * FROM social_links");
    return $stmt->fetchAll();
}

function getUnreadMessagesCount($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0");
    return $stmt->fetchColumn();
}
?>