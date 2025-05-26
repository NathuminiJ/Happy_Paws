<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

// This script will reset the admin password to "admin123"
$db = getDB();

// Generate a new password hash for "admin123"
$password = "admin123";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Update the admin user's password
$stmt = $db->prepare("UPDATE users SET password = ? WHERE username = 'admin' AND user_type = 'admin'");
$stmt->bind_param("s", $hashedPassword);

if ($stmt->execute()) {
    echo '<div style="font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center;">';
    echo '<h1 style="color: #EC4899;">Admin Password Reset</h1>';
    echo '<p style="margin: 20px 0; font-size: 16px;">The admin password has been successfully reset to: <strong>admin123</strong></p>';
    echo '<p style="margin: 20px 0; color: #666;">You can now log in with:</p>';
    echo '<div style="background: #f9f9f9; padding: 15px; border-radius: 5px; text-align: left; margin: 20px 0;">';
    echo '<p><strong>Username:</strong> admin</p>';
    echo '<p><strong>Password:</strong> admin123</p>';
    echo '</div>';
    echo '<a href="' . SITE_URL . '/login.php?type=admin" style="display: inline-block; background: #EC4899; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px;">Go to Admin Login</a>';
    echo '</div>';
} else {
    echo '<div style="font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; background: #FEE2E2;">';
    echo '<h1 style="color: #DC2626;">Error</h1>';
    echo '<p style="margin: 20px 0; font-size: 16px;">Failed to reset admin password: ' . $db->error . '</p>';
    echo '<a href="' . SITE_URL . '" style="display: inline-block; background: #EC4899; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px;">Back to Home</a>';
    echo '</div>';
}
?>
