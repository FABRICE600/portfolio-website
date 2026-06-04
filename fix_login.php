<?php
// fix_login.php - Run this once then DELETE IT!

require_once __DIR__ . '/includes/config.php';

echo "<h1>🔧 Fixing Admin Login</h1>";

try {
    // First, let's see what's in the database
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch();
    echo "<p>Current users in database: " . $count['count'] . "</p>";
    
    // Clear existing users
    $pdo->exec("DELETE FROM users");
    echo "<p>✓ Cleared existing users</p>";
    
    // Create admin user (admin / admin123)
    $admin_username = 'admin';
    $admin_password = 'admin123';
    $admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);
    $admin_email = 'admin@portfolio.com';
    $admin_name = 'Administrator';
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio, profile_image, cv_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$admin_username, $admin_hash, $admin_email, $admin_name, 'System Administrator', 'Main administrator for the portfolio system', 'default-avatar.png', 'cv.pdf']);
    echo "<p style='color: green;'>✓ Created admin user (admin / admin123)</p>";
    
    // Create fabrice user (fabrice / umuhire@2007)
    $fabrice_username = 'fabrice';
    $fabrice_password = 'umuhire@2007';
    $fabrice_hash = password_hash($fabrice_password, PASSWORD_DEFAULT);
    $fabrice_email = 'fabrice@portfolio.com';
    $fabrice_name = 'Fabrice Umuhire';
    $fabrice_bio = 'Passionate software developer from Rwanda, creating innovative web solutions for the digital world.';
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio, profile_image, cv_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$fabrice_username, $fabrice_hash, $fabrice_email, $fabrice_name, 'Software Developer Student', $fabrice_bio, 'default-avatar.png', 'cv.pdf']);
    echo "<p style='color: green;'>✓ Created fabrice user (fabrice / umuhire@2007)</p>";
    
    // Verify users were created
    $stmt = $pdo->query("SELECT id, username, email, full_name FROM users");
    $users = $stmt->fetchAll();
    
    echo "<h2>✅ Users Successfully Created!</h2>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
    foreach($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>🔐 Login Credentials:</h2>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>Username</th><th>Password</th></tr>";
    echo "<tr><td><strong>admin</strong></td><td><strong>admin123</strong></td></tr>";
    echo "<tr><td><strong>fabrice</strong></td><td><strong>umuhire@2007</strong></td></tr>";
    echo "</table>";
    
    echo "<br><br>";
    echo "<a href='admin/login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🔐 Go to Admin Login</a>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Go to Homepage</a>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #f8f9fa;
    }
    h1, h2 {
        color: #333;
    }
    table {
        width: 100%;
        background: white;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
</style>