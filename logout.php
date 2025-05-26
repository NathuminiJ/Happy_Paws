<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

// Logout the user
logoutUser();

// Redirect to login page
setFlashMessage('success', 'You have been successfully logged out');
redirect(SITE_URL . '/index.php');
