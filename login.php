<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        redirect(ADMIN_URL . '/dashboard.php');
    } else {
        redirect(USER_URL . '/index.php');
    }
}

// Check login type
$userType = isset($_GET['type']) ? $_GET['type'] : '';
if (!in_array($userType, ['admin', 'user'])) {
    setFlashMessage('error', 'Invalid login type');
    redirect(SITE_URL . '/index.php');
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password']; // No need to sanitize password
    
    // Validate input
    $errors = [];
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Attempt to login
        $result = loginUser($username, $password, $userType);
        
        if ($result['success']) {
            setFlashMessage('success', 'Login successful');
            
            if ($userType === 'admin') {
                redirect(ADMIN_URL . '/dashboard.php');
            } else {
                redirect(USER_URL . '/index.php');
            }
        } else {
            $loginError = $result['message'];
        }
    }
}

$pageTitle = ucfirst($userType) . ' Login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle . ' - ' . SITE_NAME; ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            light: '#C6A47F', // Bronze/Cinnamon
                            DEFAULT: '#8B4513', // Brown
                            dark: '#654321',   // Dark Brown
                        },
                        secondary: {
                            light: '#D2B48C', // Tan/Desert
                            DEFAULT: '#A0522D', // Sienna/Russet
                            dark: '#5D4037',   // Dark Brown/Wenge
                        },
                        accent: {
                            light: '#DEB887', // Burlywood/Light
                            DEFAULT: '#CD853F', // Peru/Cider
                            dark: '#8B4513',   // Saddle Brown
                        },
                        oldschool: {
                            bg: '#F5F5DC',      // Beige
                            border: '#A0522D',  // Brown
                            text: '#654321',    // Dark Brown
                            link: '#8B4513',    // Brown
                            highlight: '#DEB887' // Burlywood
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('https://www.transparenttextures.com/patterns/paper.png');
        }
        .old-border {
            border: 2px solid #A0522D;
            box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
        }
        .old-input {
            border: 1px solid #A0522D;
            background-color: #F8F4E3;
            font-family: 'Courier New', Courier, monospace;
            padding: 8px 12px;
            width: 100%;
        }
        .old-input:focus {
            outline: 2px solid #CD853F;
            background-color: #FFF;
        }
        .old-button {
            background-color: #D2B48C;
            color: #654321;
            border: 2px solid #A0522D;
            padding: 0.5rem 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', Courier, monospace;
        }
        .old-button:hover {
            background-color: #C6A47F;
            transform: translateY(-2px);
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
        }
        .old-checkbox {
            width: 16px;
            height: 16px;
            border: 1px solid #A0522D;
        }
        .old-title {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            letter-spacing: 2px;
        }
        .old-link {
            color: #8B4513;
            text-decoration: underline;
            font-weight: bold;
        }
        .old-link:hover {
            color: #CD853F;
        }
    </style>
</head>
<body class="bg-oldschool-bg min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto p-6">
        <!-- Logo -->
        <div class="text-center mb-8 bg-white old-border p-4">
            <h1 class="text-4xl font-bold text-primary old-title">Happy<span class="text-accent">Paws</span></h1>
            <p class="text-oldschool-text mt-2 border-t border-oldschool-border pt-2">Quality pet supplies for your furry friends</p>
            <div class="text-xs text-oldschool-text mt-1">Est. 2025</div>
        </div>
        
        <!-- Flash Messages -->
        <?php
        $flashMessage = getFlashMessage();
        if ($flashMessage):
            $alertClass = '';
            switch ($flashMessage['type']) {
                case 'success':
                    $alertClass = 'bg-green-100 border-green-400 text-green-700';
                    $icon = 'fa-check-circle';
                    break;
                case 'error':
                    $alertClass = 'bg-red-100 border-red-400 text-red-700';
                    $icon = 'fa-times-circle';
                    break;
                case 'warning':
                    $alertClass = 'bg-yellow-100 border-yellow-400 text-yellow-700';
                    $icon = 'fa-exclamation-circle';
                    break;
                default:
                    $alertClass = 'bg-blue-100 border-blue-400 text-blue-700';
                    $icon = 'fa-info-circle';
            }
        ?>
        <div id="flash-message" class="border px-4 py-3 rounded relative mb-6 <?php echo $alertClass; ?>">
            <div class="flex items-center">
                <i class="fas <?php echo $icon; ?> mr-2"></i>
                <span><?php echo $flashMessage['message']; ?></span>
            </div>
            <button class="absolute top-0 right-0 mt-3 mr-4" onclick="document.getElementById('flash-message').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>
        
        <!-- Login Form -->
        <div class="bg-white old-border p-8">
            <h2 class="text-2xl font-bold text-center text-oldschool-text mb-6 old-title border-b-2 border-oldschool-border pb-2">
                <?php echo $userType === 'admin' ? 'Admin Login' : 'Customer Login'; ?>
            </h2>
            
            <?php if (isset($loginError)): ?>
            <div class="old-error mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2 text-primary"></i>
                    <span class="text-oldschool-text font-bold"><?php echo $loginError; ?></span>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (isset($errors) && !empty($errors)): ?>
            <div class="old-error mb-4">
                <div class="text-center mb-2 font-bold text-oldschool-text">== ERROR ==</div>
                <ul class="list-disc list-inside text-oldschool-text">
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="login.php?type=<?php echo $userType; ?>" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-oldschool-text text-sm font-bold mb-2">Username:</label>
                    <div class="flex items-center old-border bg-oldschool-bg p-1">
                        <i class="fas fa-user text-primary mx-2"></i>
                        <input type="text" id="username" name="username" 
                               value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
                               class="old-input"
                               placeholder="Enter your username">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-oldschool-text text-sm font-bold mb-2">Password:</label>
                    <div class="flex items-center old-border bg-oldschool-bg p-1">
                        <i class="fas fa-lock text-primary mx-2"></i>
                        <input type="password" id="password" name="password" 
                               class="old-input"
                               placeholder="Enter your password">
                    </div>
                </div>
                
                <div class="flex items-center justify-between mb-6 border-t border-b border-oldschool-border py-3">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="old-checkbox">
                        <label for="remember" class="ml-2 block text-sm text-oldschool-text">Remember me</label>
                    </div>
                    
                    <a href="#" class="text-sm old-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="w-full old-button py-2 px-4 transition duration-300">
                    >> Login <<
                </button>
            </form>
        </div>
        
        <div class="text-center mt-4 bg-white old-border p-3">
            <p class="text-oldschool-text">
                <?php if ($userType === 'admin'): ?>
                <a href="login.php?type=user" class="old-link">Login as Customer</a>
                <?php else: ?>
                <a href="login.php?type=admin" class="old-link">Login as Admin</a>
                <?php endif; ?>
                | <a href="register.php" class="old-link">Register</a>
            </p>
            <p class="text-oldschool-text mt-2 pt-2 border-t border-oldschool-border">
                <a href="<?php echo SITE_URL; ?>/pages/user/index.php" class="old-link">
                    <i class="fas fa-home mr-1"></i> Back to Home
                </a>
            </p>
        </div>
    </div>
</body>
</html>
