<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Get category filter
$categorySlug = isset($_GET['category']) ? $_GET['category'] : '';
$category = null;

if (!empty($categorySlug)) {
    $category = getCategoryBySlug($categorySlug);
    if ($category) {
        $pageTitle = $category['name'] . ' Products';
    } else {
        // Invalid category, redirect to all products
        redirect(SITE_URL . '/pages/user/products.php');
    }
} else {
    $pageTitle = 'All Products';
}

// Get all categories for sidebar
$categories = getAllCategories();

// Get products based on category
$products = getAllProducts(null, $categorySlug);

include_once __DIR__ . '/../../components/header.php';
?>

<!-- Custom CSS for Products Page -->
<style>
    .old-product-card {
        border: 2px solid #A0522D;
        box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
        background-color: white;
        transition: all 0.3s;
    }
    
    .old-product-card:hover {
        transform: translateY(-5px) rotate(1deg);
        box-shadow: 5px 5px 10px rgba(0,0,0,0.4);
    }
    
    .old-category-link {
        font-family: 'Courier New', Courier, monospace;
        display: block;
        padding: 8px 12px;
        border-left: 3px solid transparent;
        transition: all 0.3s;
    }
    
    .old-category-link:hover {
        background-color: #DEB887;
        border-left: 3px solid #8B4513;
    }
    
    .old-category-link.active {
        background-color: #F5F5DC;
        border-left: 3px solid #8B4513;
        font-weight: bold;
        color: #8B4513;
    }
    
    .old-filter-input {
        border: 1px solid #A0522D;
        background-color: #F8F4E3;
        font-family: 'Courier New', Courier, monospace;
        padding: 8px 12px;
        width: 100%;
    }
    
    .old-filter-input:focus {
        outline: 2px solid #CD853F;
        background-color: #FFF;
    }
    
    .old-select {
        border: 1px solid #A0522D;
        background-color: #F8F4E3;
        font-family: 'Courier New', Courier, monospace;
        padding: 8px 12px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%238B4513'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
    }
    
    .old-price {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
    }
    
    .old-badge {
        font-family: 'Courier New', Courier, monospace;
        background-color: #CD853F;
        color: white;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 10px;
        transform: rotate(5deg);
    }
</style>

<!-- Products Page -->
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 bg-white old-border p-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo SITE_URL; ?>" class="text-oldschool-text hover:text-primary transition">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-oldschool-text mx-2"></i>
                    <?php if ($category): ?>
                    <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="text-oldschool-text hover:text-primary transition">
                        Products
                    </a>
                    <?php else: ?>
                    <span class="text-primary font-bold">Products</span>
                    <?php endif; ?>
                </div>
            </li>
            <?php if ($category): ?>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-oldschool-text mx-2"></i>
                    <span class="text-primary font-bold"><?php echo $category['name']; ?></span>
                </div>
            </li>
            <?php endif; ?>
        </ol>
    </nav>
    
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 lg:w-1/5 md:pr-8 mb-6 md:mb-0">
            <!-- Categories -->
            <div class="bg-white old-border p-6 mb-6">
                <h3 class="text-lg font-bold text-oldschool-text mb-4 old-title border-b-2 border-oldschool-border pb-2">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo SITE_URL; ?>/pages/user/products.php" 
                           class="old-category-link <?php echo empty($categorySlug) ? 'active' : ''; ?>">
                            >> All Products
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/pages/user/products.php?category=<?php echo $cat['slug']; ?>" 
                           class="old-category-link <?php echo $categorySlug === $cat['slug'] ? 'active' : ''; ?>">
                            >> <?php echo $cat['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Price Filter -->
            <div class="bg-white old-border p-6 mb-6">
                <h3 class="text-lg font-bold text-oldschool-text mb-4 old-title border-b-2 border-oldschool-border pb-2">Filter by Price</h3>
                <form action="" method="GET">
                    <?php if ($categorySlug): ?>
                    <input type="hidden" name="category" value="<?php echo $categorySlug; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <label for="min_price" class="block text-oldschool-text text-sm font-bold mb-2">Min Price ($):</label>
                        <input type="number" id="min_price" name="min_price" min="0" step="0.01" 
                               value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>"
                               class="old-filter-input">
                    </div>
                    
                    <div class="mb-4">
                        <label for="max_price" class="block text-oldschool-text text-sm font-bold mb-2">Max Price ($):</label>
                        <input type="number" id="max_price" name="max_price" min="0" step="0.01" 
                               value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>"
                               class="old-filter-input">
                    </div>
                    
                    <button type="submit" class="w-full old-button py-2 px-4 transition duration-300">
                        >> Apply Filter <<
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <div class="bg-white old-border p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-oldschool-text mb-3 sm:mb-0 old-title border-b-2 border-oldschool-border pb-2">
                        <?php echo $category ? $category['name'] . ' Products' : 'All Products'; ?>
                    </h1>
                    
                    <div class="flex items-center bg-oldschool-bg p-2 old-border">
                        <label for="sort-products" class="mr-2 text-oldschool-text font-bold">Sort by:</label>
                        <select id="sort-products" class="old-select">
                            <option value="default">Default</option>
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                            <option value="name-a-z">Name: A to Z</option>
                            <option value="name-z-a">Name: Z to A</option>
                        </select>
                    </div>
                </div>
                
                <?php if (empty($products)): ?>
                <div class="text-center py-8 old-border bg-white p-6">
                    <p class="text-lg text-oldschool-text">No products available in this category yet. Check back soon!</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($products as $product): ?>
                    <div class="old-product-card relative">
                        <?php if (!empty($product['sale_price'])): ?>
                        <div class="old-badge">SALE!</div>
                        <?php endif; ?>
                        <div class="text-center bg-oldschool-bg border-b-2 border-oldschool-border py-2">
                            <span class="text-sm font-bold text-oldschool-text uppercase"><?php echo $product['category_name']; ?></span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $product['slug']; ?>">
                            <img src="<?php echo !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/300x300?text=Product+Image'; ?>" 
                                 alt="<?php echo $product['name']; ?>" 
                                 class="w-full h-48 object-cover p-2">
                        </a>
                        <div class="p-4">
                            <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $product['slug']; ?>" class="block">
                                <h3 class="text-lg font-bold text-oldschool-text mt-1 hover:text-primary transition border-b border-oldschool-border pb-2"><?php echo $product['name']; ?></h3>
                            </a>
                            <div class="mt-3 flex justify-between items-center border-b border-oldschool-border pb-3">
                                <div>
                                    <?php if (!empty($product['sale_price'])): ?>
                                    <span class="text-oldschool-text line-through">$<?php echo number_format($product['price'], 2); ?></span>
                                    <span class="text-lg font-bold text-primary ml-1 old-price">$<?php echo number_format($product['sale_price'], 2); ?></span>
                                    <?php else: ?>
                                    <span class="text-lg font-bold text-oldschool-text old-price">$<?php echo number_format($product['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-primary flex">
                                        <i class="fas fa-paw"></i>
                                        <i class="fas fa-paw"></i>
                                        <i class="fas fa-paw"></i>
                                        <i class="fas fa-paw"></i>
                                        <i class="fas fa-paw-half-alt"></i>
                                    </div>
                                    <span class="text-xs text-oldschool-text ml-1">(4.5)</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full old-button py-2 px-4 transition duration-300">
                                        <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Sort products functionality
    document.getElementById('sort-products').addEventListener('change', function() {
        const sortValue = this.value;
        const productCards = document.querySelectorAll('.grid > div');
        const productGrid = document.querySelector('.grid');
        
        const productArray = Array.from(productCards);
        
        productArray.sort((a, b) => {
            if (sortValue === 'price-low') {
                const priceA = parseFloat(a.querySelector('.font-bold').innerText.replace('$', ''));
                const priceB = parseFloat(b.querySelector('.font-bold').innerText.replace('$', ''));
                return priceA - priceB;
            } else if (sortValue === 'price-high') {
                const priceA = parseFloat(a.querySelector('.font-bold').innerText.replace('$', ''));
                const priceB = parseFloat(b.querySelector('.font-bold').innerText.replace('$', ''));
                return priceB - priceA;
            } else if (sortValue === 'name-asc') {
                const nameA = a.querySelector('h3').innerText;
                const nameB = b.querySelector('h3').innerText;
                return nameA.localeCompare(nameB);
            } else if (sortValue === 'name-desc') {
                const nameA = a.querySelector('h3').innerText;
                const nameB = b.querySelector('h3').innerText;
                return nameB.localeCompare(nameA);
            }
            return 0;
        });
        
        // Clear grid and append sorted items
        productGrid.innerHTML = '';
        productArray.forEach(product => {
            productGrid.appendChild(product);
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
