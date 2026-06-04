<?php
// fix_database.php - Run this once then DELETE IT!

require_once __DIR__ . '/includes/config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Fix Database Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        h1 { color: #333; margin-bottom: 20px; }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .btn { display: inline-block; padding: 10px 20px; margin-top: 20px; text-decoration: none; border-radius: 5px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Database Login Fix</h1>";

try {
    // Clear existing users
    $pdo->exec("TRUNCATE TABLE users");
    echo "<p class='success'>✓ Cleared existing users</p>";
    
    // Create admin user (admin / admin123)
    $admin_password = 'admin123';
    $admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio, profile_image, cv_file) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        'admin',
        $admin_hash,
        'admin@portfolio.com',
        'System Administrator',
        'System Admin',
        'Main administrator for the portfolio system',
        'default-avatar.png',
        'cv.pdf'
    ]);
    echo "<p class='success'>✓ Created admin user</p>";
    
    // Create fabrice user (fabrice / umuhire@2007)
    $fabrice_password = 'umuhire@2007';
    $fabrice_hash = password_hash($fabrice_password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio, profile_image, cv_file) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        'fabrice',
        $fabrice_hash,
        'fabrice@portfolio.com',
        'Fabrice Umuhire',
        'Software Developer Student',
        'Passionate software developer from Rwanda, creating innovative web solutions for the digital world.',
        'default-avatar.png',
        'cv.pdf'
    ]);
    echo "<p class='success'>✓ Created fabrice user</p>";
    
    // Verify users
    $stmt = $pdo->query("SELECT id, username, email, full_name FROM users");
    $users = $stmt->fetchAll();
    
    echo "<h2>✅ Users Successfully Created!</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
    foreach($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td><strong>{$user['username']}</strong></td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test password verification
    echo "<h2>🔐 Password Verification Test</h2>";
    
    // Test admin
    $test_admin = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
    $test_admin->execute();
    $admin_user = $test_admin->fetch();
    
    if (password_verify('admin123', $admin_user['password'])) {
        echo "<p class='success'>✓ Admin password verified: admin123 works!</p>";
    } else {
        echo "<p class='error'>✗ Admin password verification failed!</p>";
    }
    
    // Test fabrice
    $test_fabrice = $pdo->prepare("SELECT * FROM users WHERE username = 'fabrice'");
    $test_fabrice->execute();
    $fabrice_user = $test_fabrice->fetch();
    
    if (password_verify('umuhire@2007', $fabrice_user['password'])) {
        echo "<p class='success'>✓ Fabrice password verified: umuhire@2007 works!</p>";
    } else {
        echo "<p class='error'>✗ Fabrice password verification failed!</p>";
    }
    
    echo "<br>";
    echo "<a href='admin/login.php' class='btn btn-primary'>🔐 Go to Admin Login</a> ";
    echo "<a href='index.php' class='btn btn-success'>🏠 Go to Homepage</a>";
    
} catch(PDOException $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
    </div>
</body>
</html>