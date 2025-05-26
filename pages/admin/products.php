<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require admin privileges
requireAdmin();

// Handle product deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];
    
    if (deleteProduct($productId)) {
        setFlashMessage('success', 'Product deleted successfully');
    } else {
        setFlashMessage('error', 'Failed to delete product');
    }
    
    redirect(ADMIN_URL . '/products.php');
}

// Get all products
$products = getAllProducts();

// Get all categories for filter
$categories = getAllCategories();

// Filter by category if provided
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
if (!empty($categoryFilter)) {
    $filteredProducts = [];
    foreach ($products as $product) {
        if ($product['category_id'] == $categoryFilter) {
            $filteredProducts[] = $product;
        }
    }
    $products = $filteredProducts;
}

// Search functionality
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($searchQuery)) {
    $products = searchProducts($searchQuery);
}

$pageTitle = 'Manage Products';
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
                            text: '#654321',
                            bg: '#F5F5DC',
                            light: '#F8F4E3',
                            highlight: '#DEB887',
                            border: '#A0522D'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Old School Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
        
        body {
            background-image: url('https://www.transparenttextures.com/patterns/paper.png');
            background-color: #F5F5DC;
        }
        
        .font-courier {
            font-family: 'Courier Prime', monospace;
        }
        
        .old-border {
            border: 2px solid #A0522D;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        }
        
        .old-title {
            font-family: 'Courier Prime', monospace;
            font-weight: bold;
            color: #8B4513;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        
        .old-button {
            background-color: #8B4513;
            color: white;
            font-family: 'Courier Prime', monospace;
            font-weight: bold;
            border: 2px solid #654321;
            transition: all 0.3s;
            box-shadow: 3px 3px 5px rgba(0,0,0,0.2);
        }
        
        .old-button:hover {
            background-color: #A0522D;
            transform: translateY(-2px);
            box-shadow: 4px 6px 8px rgba(0,0,0,0.3);
        }
        
        .old-card {
            background-color: #F5F5DC;
            border: 2px solid #A0522D;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        }
        
        .old-input {
            border: 1px solid #A0522D;
            background-color: #F8F4E3;
            font-family: 'Courier Prime', monospace;
        }
        
        .old-sidebar-item {
            font-family: 'Courier Prime', monospace;
            transition: all 0.3s;
        }
        
        .old-sidebar-item:hover {
            background-color: #8B4513;
            padding-left: 1.5rem;
        }
        
        .old-sidebar-item.active {
            background-color: #8B4513;
            border-left: 4px solid #CD853F;
        }
        
        /* Custom scrollbar for old-school feel */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #F5F5DC;
            border: 1px solid #A0522D;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #8B4513;
            border: 1px solid #CD853F;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #654321;
        }
        
        .old-table {
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid #A0522D;
        }
        
        .old-table th {
            border-bottom: 2px solid #A0522D;
            background-color: rgba(139, 69, 19, 0.1);
        }
        
        .old-table tr:hover {
            background-color: rgba(222, 184, 135, 0.3);
        }
        
        .typewriter {
            overflow: hidden;
            border-right: .15em solid #8B4513;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #8B4513; }
        }
        
        .old-table th {
            font-family: 'Courier Prime', monospace;
            font-weight: bold;
            color: #654321;
            border-bottom: 2px solid #A0522D;
        }
        
        .old-table td {
            font-family: 'Courier Prime', monospace;
        }
        
        .old-table tr:hover {
            background-color: #DEB887;
        }
        
        .typewriter {
            overflow: hidden;
            border-right: .15em solid #8B4513;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
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
<body class="bg-oldschool-bg min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-primary-dark text-white w-64 min-h-screen flex flex-col old-border">
        <div class="p-4 bg-primary border-b-2 border-accent">
            <h2 class="text-2xl font-bold font-courier">Happy<span class="text-accent">Paws</span></h2>
            <p class="text-gray-200 text-sm font-courier">Admin Control Panel</p>
        </div>
        
        <nav class="flex-grow">
            <ul class="mt-6">
                <li class="px-4 py-3 old-sidebar-item">
                    <a href="<?php echo ADMIN_URL; ?>/dashboard.php" class="flex items-center">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="px-4 py-3 old-sidebar-item active">
                    <a href="<?php echo ADMIN_URL; ?>/products.php" class="flex items-center">
                        <i class="fas fa-box w-6"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="px-4 py-3 old-sidebar-item">
                    <a href="<?php echo ADMIN_URL; ?>/categories.php" class="flex items-center">
                        <i class="fas fa-tags w-6"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="px-4 py-3 old-sidebar-item">
                    <a href="<?php echo ADMIN_URL; ?>/orders.php" class="flex items-center">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="px-4 py-3 old-sidebar-item">
                    <a href="<?php echo ADMIN_URL; ?>/users.php" class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            
            <div class="mt-auto p-4 border-t border-accent">
                <a href="<?php echo SITE_URL; ?>" class="flex items-center text-gray-300 hover:text-white transition old-sidebar-item py-2">
                    <i class="fas fa-home w-6"></i>
                    <span>Visit Store</span>
                </a>
                <a href="<?php echo SITE_URL; ?>/logout.php" class="flex items-center text-gray-300 hover:text-white transition mt-2 old-sidebar-item py-2">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-grow p-6">
        <!-- Flash Messages -->
        <?php
        $flashMessage = getFlashMessage();
        if ($flashMessage):
        ?>
        <div class="mb-6 p-4 old-border <?php echo $flashMessage['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> font-courier">
            <?php echo $flashMessage['message']; ?>
        </div>
        <?php endif; ?>
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-oldschool-text old-title typewriter font-courier"><?php echo $pageTitle; ?></h1>
            <a href="<?php echo ADMIN_URL; ?>/add-product.php" class="old-button py-2 px-4 rounded-md">
                <i class="fas fa-plus mr-2"></i> Add New Product
            </a>
        </div>
        
        <!-- Filters -->
        <div class="bg-oldschool-light old-card p-6 mb-6">
            <form action="" method="GET" class="flex flex-wrap items-center gap-4">
                <!-- Search -->
                <div class="flex-grow min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-oldschool-text mb-1 font-courier">Search Products</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Search by name or description..." class="w-full px-4 py-2 old-input rounded-md">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-oldschool-text hover:text-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="min-w-[200px]">
                    <label for="category" class="block text-sm font-medium text-oldschool-text mb-1 font-courier">Filter by Category</label>
                    <select id="category" name="category" class="w-full px-4 py-2 old-input rounded-md" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $categoryFilter == $category['id'] ? 'selected' : ''; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Reset Filters -->
                <?php if (!empty($searchQuery) || !empty($categoryFilter)): ?>
                <div class="flex items-end">
                    <a href="<?php echo ADMIN_URL; ?>/products.php" class="old-button py-1 px-3 inline-block">
                        <i class="fas fa-times mr-1"></i> Clear Filters
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Products Table -->
        <div class="bg-oldschool-light old-card overflow-hidden">
            <?php if (empty($products)): ?>
            <div class="p-6 text-center">
                <p class="text-oldschool-text font-courier">No products found. <?php echo !empty($searchQuery) || !empty($categoryFilter) ? 'Try a different search or filter.' : ''; ?></p>
                <a href="<?php echo ADMIN_URL; ?>/add-product.php" class="inline-block mt-4 old-button py-2 px-4">
                    <i class="fas fa-plus mr-1"></i> Add your first product
                </a>
            </div>
            <?php else: ?>
            <table class="min-w-full old-table">
                <thead class="bg-primary bg-opacity-20">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dashed divide-primary">
                    <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-oldschool-highlight">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 object-cover old-border transform rotate-1" 
                                         src="<?php echo !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/100x100?text=No+Image'; ?>" 
                                         alt="<?php echo $product['name']; ?>">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-oldschool-text font-courier"><?php echo $product['name']; ?></div>
                                    <div class="text-sm text-oldschool-text font-courier"><?php echo substr($product['description'], 0, 50) . (strlen($product['description']) > 50 ? '...' : ''); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-courier font-bold transform rotate-1 inline-block old-border bg-primary bg-opacity-20 text-oldschool-text">
                                <?php echo $product['category_name'] ?? 'Uncategorized'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-courier">
                            <?php if (!empty($product['sale_price'])): ?>
                            <div class="flex items-center">
                                <span class="text-oldschool-text line-through mr-2 font-courier">$<?php echo number_format($product['price'], 2); ?></span>
                                <span class="text-primary font-bold font-courier">$<?php echo number_format($product['sale_price'], 2); ?></span>
                            </div>
                            <?php else: ?>
                            <span class="text-oldschool-text font-courier">$<?php echo number_format($product['price'], 2); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-courier font-bold transform rotate-1 inline-block old-border <?php echo $product['stock'] <= 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                <?php echo $product['stock']; ?> in stock
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-oldschool-text font-courier">
                            <?php echo date('M d, Y', strtotime($product['created_at'])); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="<?php echo ADMIN_URL; ?>/edit-product.php?id=<?php echo $product['id']; ?>" class="old-button px-2 py-1 inline-block mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="old-button bg-red-600 hover:bg-red-700 px-2 py-1 inline-block" onclick="confirmDelete(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-oldschool-light old-card p-6 max-w-md w-full transform rotate-1">
            <h3 class="text-xl font-bold text-oldschool-text mb-4 old-title font-courier">Confirm Delete</h3>
            <p class="text-oldschool-text mb-6 font-courier">Are you sure you want to delete <span id="productName" class="font-bold"></span>? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="old-button bg-oldschool-bg text-oldschool-text py-2 px-4">
                    Cancel
                </button>
                <a id="confirmDeleteBtn" href="#" class="old-button bg-red-600 hover:bg-red-700 py-2 px-4">
                    Delete
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Delete confirmation
        function confirmDelete(productId, productName) {
            document.getElementById('productName').textContent = productName;
            document.getElementById('confirmDeleteBtn').href = '<?php echo ADMIN_URL; ?>/products.php?action=delete&id=' + productId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });
        
        // Add old-school paper texture effect
        document.addEventListener('DOMContentLoaded', function() {
            // Add subtle rotation to product images and cards
            const productImages = document.querySelectorAll('.old-border');
            productImages.forEach(img => {
                const randomRotation = (Math.random() * 6) - 3; // Random rotation between -3 and 3 degrees
                img.style.transform = `rotate(${randomRotation}deg)`;
            });
            
            // Add typewriter effect to title
            const title = document.querySelector('.typewriter');
            if (title) {
                title.style.width = '0';
                setTimeout(() => {
                    title.style.width = '100%';
                }, 300);
            }
            
            // Add vintage paper texture to cards
            const cards = document.querySelectorAll('.old-card');
            cards.forEach(card => {
                card.style.backgroundImage = "url('https://www.transparenttextures.com/patterns/paper.png')";
            });
        });
        
        // Close flash message after 5 seconds
        setTimeout(function() {
            var flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.opacity = '0';
                setTimeout(function() {
                    flashMessage.style.display = 'none';
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>
