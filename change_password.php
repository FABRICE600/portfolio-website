<?php
// change_password.php - Run this ONCE then DELETE IT!

require_once __DIR__ . '/includes/config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Change Admin Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #007bff; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .btn { display: inline-block; padding: 12px 24px; margin: 10px; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Changing Admin to Fabrice</h1>";

try {
    // First, check current users
    echo "<h2>📋 Current Users Before Change:</h2>";
    $stmt = $pdo->query("SELECT id, username, email, full_name FROM users");
    $users = $stmt->fetchAll();
    
    if(count($users) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
        foreach($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['full_name']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in database.</p>";
    }
    
    // Delete all existing users
    $pdo->exec("DELETE FROM users");
    echo "<p class='success'>✓ Cleared all existing users</p>";
    
    // Create new user: fabrice with password umuhire@2007
    $username = 'fabrice';
    $password = 'umuhire@2007';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $email = 'fabrice@portfolio.com';
    $full_name = 'Fabrice Umuhire';
    $title = 'Software Developer Student';
    $bio = 'Passionate software developer from Rwanda, creating innovative web solutions for the digital world.';
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio, profile_image, cv_file) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $username,
        $hashed_password,
        $email,
        $full_name,
        $title,
        $bio,
        'default-avatar.png',
        'cv.pdf'
    ]);
    
    echo "<p class='success'>✓✓✓ User 'fabrice' created successfully!</p>";
    
    // Verify the password works
    $verify_stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'fabrice'");
    $verify_stmt->execute();
    $new_user = $verify_stmt->fetch();
    
    if($new_user && password_verify('umuhire@2007', $new_user['password'])) {
        echo "<p class='success'>✓ Password verification: SUCCESS! 'umuhire@2007' works correctly.</p>";
    } else {
        echo "<p class='error'>✗ Password verification failed! Trying alternative method...</p>";
        
        // Alternative method - force update
        $new_hash = password_hash('umuhire@2007', PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'fabrice'");
        $update->execute([$new_hash]);
        
        echo "<p class='success'>✓ Password reset with alternative method.</p>";
    }
    
    // Show final users
    echo "<h2>📋 Final Users in Database:</h2>";
    $stmt = $pdo->query("SELECT id, username, email, full_name FROM users");
    $final_users = $stmt->fetchAll();
    
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
    foreach($final_users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td><strong style='color: #28a745;'>{$user['username']}</strong></td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Display credentials
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin-top: 0;'>✅ NEW LOGIN CREDENTIALS:</h3>";
    echo "<p style='font-size: 18px;'><strong>🔐 Username:</strong> <code style='background: #fff; padding: 5px 10px; border-radius: 5px;'>fabrice</code></p>";
    echo "<p style='font-size: 18px;'><strong>🔐 Password:</strong> <code style='background: #fff; padding: 5px 10px; border-radius: 5px;'>umuhire@2007</code></p>";
    echo "<p class='info'><i class='fas fa-info-circle'></i> These credentials are for your reference only.</p>";
    echo "</div>";
    
    echo "<br>";
    echo "<a href='admin/login.php' class='btn btn-primary'>🔐 Go to Admin Login</a>";
    echo "<a href='index.php' class='btn btn-success'>🏠 Go to Homepage</a>";
    
} catch(PDOException $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
    </div>
</body>
</html>