<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require admin privileges
requireAdmin();

// Get all categories
$categories = getAllCategories();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = sanitize($_POST['name']);
    $slug = sanitize($_POST['slug']);
    $description = sanitize($_POST['description']);
    $price = (float)$_POST['price'];
    $salePrice = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
    $stock = (int)$_POST['stock'];
    $categoryId = (int)$_POST['category_id'];
    
    // Validate input
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Product name is required';
    }
    
    if (empty($slug)) {
        $errors[] = 'Product slug is required';
    }
    
    if ($price <= 0) {
        $errors[] = 'Price must be greater than zero';
    }
    
    if ($salePrice !== null && $salePrice <= 0) {
        $errors[] = 'Sale price must be greater than zero';
    }
    
    if ($salePrice !== null && $salePrice >= $price) {
        $errors[] = 'Sale price must be less than regular price';
    }
    
    if ($stock < 0) {
        $errors[] = 'Stock cannot be negative';
    }
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../assets/images/products/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $uniqueName = uniqid() . '_' . time() . '.' . $fileExt;
        $targetFile = $uploadDir . $uniqueName;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            $errors[] = 'File is not an image';
        }
        
        // Check file size (max 5MB)
        if ($_FILES['image']['size'] > 5000000) {
            $errors[] = 'File is too large (max 5MB)';
        }
        
        // Allow certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExt, $allowedFormats)) {
            $errors[] = 'Only JPG, JPEG, PNG & GIF files are allowed';
        }
        
        // If no errors, try to upload file
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = SITE_URL . '/assets/images/products/' . $uniqueName;
            } else {
                $errors[] = 'Failed to upload image';
            }
        }
    }
    
    // If no errors, create product
    if (empty($errors)) {
        $productData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'price' => $price,
            'sale_price' => $salePrice,
            'image' => $image,
            'stock' => $stock,
            'category_id' => $categoryId
        ];
        
        $productId = createProduct($productData);
        
        if ($productId) {
            setFlashMessage('success', 'Product added successfully');
            redirect(ADMIN_URL . '/products.php');
        } else {
            $errors[] = 'Failed to add product';
        }
    }
}

$pageTitle = 'Add New Product';
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
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-amber-50 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-secondary-dark text-white w-64 min-h-screen flex flex-col">
        <div class="p-4 bg-primary-dark">
            <h2 class="text-2xl font-bold">Happy<span class="text-accent">Paws</span></h2>
            <p class="text-gray-200 text-sm">Admin Dashboard</p>
        </div>
        
        <nav class="flex-grow">
            <ul class="mt-6">
                <li class="px-4 py-3 hover:bg-primary hover:bg-opacity-80 transition">
                    <a href="<?php echo ADMIN_URL; ?>/dashboard.php" class="flex items-center">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="px-4 py-3 bg-primary">
                    <a href="<?php echo ADMIN_URL; ?>/products.php" class="flex items-center">
                        <i class="fas fa-bone w-6"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-primary hover:bg-opacity-80 transition">
                    <a href="<?php echo ADMIN_URL; ?>/categories.php" class="flex items-center">
                        <i class="fas fa-paw w-6"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-primary hover:bg-opacity-80 transition">
                    <a href="<?php echo ADMIN_URL; ?>/orders.php" class="flex items-center">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-primary hover:bg-opacity-80 transition">
                    <a href="<?php echo ADMIN_URL; ?>/users.php" class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-primary hover:bg-opacity-80 transition">
                    <a href="<?php echo ADMIN_URL; ?>/settings.php" class="flex items-center">
                        <i class="fas fa-cog w-6"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="p-4 border-t border-primary-dark">
            <a href="<?php echo SITE_URL; ?>/logout.php" class="flex items-center text-white hover:text-white transition bg-primary p-2 rounded-md">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-grow p-6">
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
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Add New Product</h1>
            <a href="<?php echo ADMIN_URL; ?>/products.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>
        
        <!-- Error Messages -->
        <?php if (isset($errors) && !empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <h3 class="font-bold">Please fix the following errors:</h3>
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <!-- Product Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="<?php echo ADMIN_URL; ?>/add-product.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Product Name *</label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug *</label>
                            <div class="flex items-center">
                                <input type="text" id="slug" name="slug" 
                                       value="<?php echo isset($slug) ? htmlspecialchars($slug) : ''; ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       required>
                                <button type="button" id="generateSlug" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-md transition duration-300">
                                    Generate
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Used in URLs. Must be unique.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea id="description" name="description" rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category *</label>
                            <select id="category_id" name="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo isset($categoryId) && $categoryId == $category['id'] ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Regular Price ($) *</label>
                            <input type="number" id="price" name="price" step="0.01" min="0" 
                                   value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="sale_price" class="block text-gray-700 text-sm font-bold mb-2">Sale Price ($)</label>
                            <input type="number" id="sale_price" name="sale_price" step="0.01" min="0" 
                                   value="<?php echo isset($salePrice) ? htmlspecialchars($salePrice) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Leave empty for no sale price.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity *</label>
                            <input type="number" id="stock" name="stock" min="0" 
                                   value="<?php echo isset($stock) ? htmlspecialchars($stock) : '0'; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 5MB)</p>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            <div id="image-preview" class="mt-3 hidden">
                                <div class="flex items-center">
                                    <img id="preview-img" src="#" alt="Preview" class="h-20 w-20 object-cover rounded-md">
                                    <button type="button" id="remove-image" class="ml-3 text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='<?php echo ADMIN_URL; ?>/products.php'" class="bg-secondary-light hover:bg-secondary text-gray-800 font-bold py-2 px-4 rounded-md mr-2 transition duration-300">
                            Cancel
                        </button>
                        <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded-md transition duration-300">
                            Add Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <script>
        // Generate slug from product name
        document.getElementById('generateSlug').addEventListener('click', function() {
            const name = document.getElementById('name').value;
            if (name) {
                const slug = name
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')     // Replace spaces with hyphens
                    .replace(/-+/g, '-');     // Replace multiple hyphens with single hyphen
                
                document.getElementById('slug').value = slug;
            }
        });
        
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Remove image
        document.getElementById('remove-image').addEventListener('click', function() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        });
    </script>
</body>
</html>
