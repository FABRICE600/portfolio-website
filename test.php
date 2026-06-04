<?php
echo "<h1>Portfolio System Test</h1>";

echo "<h2>1. Testing Config</h2>";
require_once __DIR__ . '/includes/config.php';
echo "✓ config.php loaded<br>";
echo "SITE_NAME: " . SITE_NAME . "<br>";

echo "<h2>2. Testing Database</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();
    echo "✓ Database connected! Users: " . $count . "<br>";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "<br>";
}

echo "<h2>3. Testing Functions</h2>";
require_once __DIR__ . '/includes/functions.php';
echo "✓ functions.php loaded<br>";

echo "<h2>4. System Status</h2>";
echo "<ul>";
echo "<li>✓ PHP Version: " . phpversion() . "</li>";
echo "<li>✓ Upload Max Size: " . ini_get('upload_max_filesize') . "</li>";
echo "<li>✓ Post Max Size: " . ini_get('post_max_size') . "</li>";
echo "</ul>";

echo "<h2>5. Links</h2>";
echo "<a href='index.php' class='btn btn-primary'>Go to Homepage</a> ";
echo "<a href='admin/login.php' class='btn btn-success'>Go to Admin Login</a>";
?>
<style>.btn{display:inline-block;padding:10px20px;margin:10px;text-decoration:none;border-radius:5px;color:white;}.btn-primary{background:#007bff;}.btn-success{background:#28a745;}</style>