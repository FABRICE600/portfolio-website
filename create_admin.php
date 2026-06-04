<?php
// File: create_admin.php - Run this once then DELETE IT!

require_once __DIR__ . '/includes/config.php';

$username = 'fabrice';
$password = 'umuhire@2007';
$email = 'fabrice@portfolio.com';
$full_name = 'Fabrice Umuhire';
$title = 'Software Developer Student';
$bio = 'Passionate software developer from Rwanda, creating innovative web solutions.';

// Generate password hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Admin Account Setup</h2>";
echo "<p><strong>Username:</strong> " . $username . "</p>";
echo "<p><strong>Password:</strong> " . $password . "</p>";
echo "<p><strong>Password Hash:</strong> " . $hashed_password . "</p>";
echo "<hr>";

try {
    // Delete existing admin if exists
    $pdo->exec("DELETE FROM users WHERE username = 'admin' OR username = 'fabrice'");
    
    // Insert new admin
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, title, bio) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashed_password, $email, $full_name, $title, $bio]);
    
    echo "<div style='color: green; font-weight: bold;'>✓ Admin user 'fabrice' created successfully!</div>";
    echo "<br><a href='admin/login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Admin Login →</a>";
    
} catch(PDOException $e) {
    echo "<div style='color: red;'>Error: " . $e->getMessage() . "</div>";
}
?>

<style>
    body { font-family: Arial, sans-serif; padding: 50px; text-align: center; }
    hr { margin: 20px 0; }
</style>