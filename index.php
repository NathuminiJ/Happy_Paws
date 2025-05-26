<?php
require_once __DIR__ . '/config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        redirect(ADMIN_URL . '/dashboard.php');
    } else {
        redirect(USER_URL . '/index.php');
    }
}

$pageTitle = 'Login';
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
            background-image: url('../assets/images/6831f7fdf1c09_1748105213.jpg');
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
        .old-error {
            background-color: #F8D7DA;
            border: 2px dashed #A0522D;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
        }
        .login-card {
            transform: rotate(-1deg);
        }
        .login-card:hover {
            transform: rotate(0deg);
        }
        .login-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .typewriter-text {
            overflow: hidden;
            border-right: .15em solid #8B4513;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: 
                typing 3.5s steps(40, end),
                blink-caret .75s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #8B4513; }
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
        
        <!-- Login Type Selection -->
        <div class="bg-white old-border p-8 mb-6">
            <h2 class="text-2xl font-bold text-center text-oldschool-text mb-6 old-title border-b-2 border-oldschool-border pb-2">Select Login Type</h2>
            <div class="typewriter-text text-center text-oldschool-text mb-4">Welcome to Happy Paws!</div>
            
            <div class="grid grid-cols-2 gap-6">
                <a href="login.php?type=admin" class="login-card old-border bg-oldschool-bg hover:bg-oldschool-highlight text-oldschool-text font-bold py-4 px-4 transition duration-300 flex flex-col items-center justify-center">
                    <i class="fas fa-user-shield login-icon text-primary"></i>
                    <span class="font-bold">Admin</span>
                </a>
                <a href="login.php?type=user" class="login-card old-border bg-oldschool-bg hover:bg-oldschool-highlight text-oldschool-text font-bold py-4 px-4 transition duration-300 flex flex-col items-center justify-center">
                    <i class="fas fa-user login-icon text-primary"></i>
                    <span class="font-bold">Customer</span>
                </a>
            </div>
        </div>
        
        <div class="text-center bg-white old-border p-3">
            <p class="text-oldschool-text">Don't have an account? <a href="register.php" class="old-link">Register now</a></p>
        </div>
    </div>
</body>
</html>
