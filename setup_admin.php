<?php
// setup_admin.php - Run once then DELETE

require_once 'includes/config.php';

// Admin credentials
$username = 'fabrice';
$password = 'umuhire@2007';
$email = 'fabrice@portfolio.com';
$full_name = 'Fabrice Umuhire';
$title = 'Software Developer Student';
$bio = 'Passionate software developer from Rwanda, creating innovative web solutions for the digital world.';

// Generate hash
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    // Clear existing
    $pdo->exec("TRUNCATE TABLE users");
    
    // Insert new admin
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hash, $email, $full_name, $title, $bio]);
    
    echo "<h2 style='color: green;'>✅ Admin Account Created Successfully!</h2>";
    echo "<table border='1' cellpadding='10' style='margin: 20px auto; border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    echo "<tr><td>Username</td><td><strong>{$username}</strong></td></tr>";
    echo "<tr><td>Password</td><td><strong>{$password}</strong></td></tr>";
    echo "<tr><td>Email</td><td>{$email}</td></tr>";
    echo "<tr><td>Full Name</td><td>{$full_name}</td></tr>";
    echo "</table>";
    echo "<br><a href='admin/login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Go to Admin Login</a>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error: " . $e->getMessage() . "</h2>";
}
?>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
    table { margin: 20px auto; }
    th, td { padding: 10px 20px; text-align: left; }
    th { background: #f0f0f0; }
</style>