<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$user = getUserData($pdo);
$cv_file = isset($user['cv_file']) ? $user['cv_file'] : '';
$file_path = UPLOAD_DIR . 'cv/' . $cv_file;

if ($cv_file && $cv_file != 'cv.pdf' && file_exists($file_path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . ($user['full_name'] ?? 'Software_Developer') . '_CV.pdf"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Download CV</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 50px; text-align: center; }
            .message { background: #f8d7da; color: #721c24; padding: 30px; border-radius: 10px; max-width: 500px; margin: 0 auto; }
            .btn { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class="message">
            <h2>CV Not Found</h2>
            <p>Please upload your CV in the admin panel.</p>
            <a href="admin/login.php" class="btn">Go to Admin Panel</a>
        </div>
    </body>
    </html>
    <?php
}
?>