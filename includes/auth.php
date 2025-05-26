<?php
require_once __DIR__ . '/../config/config.php';

// Function to register a new user
function registerUser($username, $email, $password, $userType = 'user') {
    $db = getDB();
    
    // Check if username or email already exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['username'] === $username) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        if ($user['email'] === $email) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $db->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $userType);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Registration successful'];
    } else {
        return ['success' => false, 'message' => 'Registration failed: ' . $db->error];
    }
}

// Function to login a user
function loginUser($username, $password, $userType) {
    $db = getDB();
    
    // Get user by username and user type
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $username, $userType);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return ['success' => false, 'message' => 'Invalid username or user type'];
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password - check both hashed and plain text password
    if (password_verify($password, $user['password']) || $password === $user['password']) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];
        
        // If using plain text password, update it to a hashed version for security
        if ($password === $user['password']) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->bind_param("si", $hashedPassword, $user['id']);
            $updateStmt->execute();
        }
        
        return [
            'success' => true, 
            'message' => 'Login successful',
            'user' => $user
        ];
    } else {
        return ['success' => false, 'message' => 'Invalid password'];
    }
}

// Function to logout a user
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    redirect(SITE_URL . '/index.php');
}

// Function to check if user has access to admin area
function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        setFlashMessage('error', 'You do not have permission to access this page');
        redirect(SITE_URL . '/index.php');
    }
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        setFlashMessage('error', 'You must be logged in to access this page');
        redirect(SITE_URL . '/index.php');
    }
}
