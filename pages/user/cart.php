<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require login
requireLogin();

// Get cart items
$cartItems = getCartItems($_SESSION['user_id']);
$cartTotal = getCartTotal($_SESSION['user_id']);

$pageTitle = 'Shopping Cart';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Shopping Cart Page -->
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo SITE_URL; ?>" class="text-gray-700 hover:text-primary transition">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-primary">Shopping Cart</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Your Shopping Cart</h1>
    
    <?php if (empty($cartItems)): ?>
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="text-6xl text-gray-300 mb-4">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your cart is empty</h2>
        <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
        <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-md transition duration-300">
            Continue Shopping
        </a>
    </div>
    <?php else: ?>
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-md object-cover" 
                                                 src="<?php echo !empty($item['image']) ? $item['image'] : 'https://via.placeholder.com/100x100?text=No+Image'; ?>" 
                                                 alt="<?php echo $item['name']; ?>">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $item['slug']; ?>" class="hover:text-primary transition">
                                                    <?php echo $item['name']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">$<?php echo number_format($item['price'], 2); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST" class="flex items-center">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                        <button type="button" class="quantity-btn decrease bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-l-md transition duration-300">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" 
                                               class="quantity-input w-12 py-1 px-2 border-y border-gray-300 text-center focus:outline-none">
                                        <button type="button" class="quantity-btn increase bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-r-md transition duration-300">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="submit" class="ml-2 text-blue-600 hover:text-blue-900 transition">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST" class="inline">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between">
                        <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="text-primary hover:text-primary-dark transition">
                            <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                        </a>
                        <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST">
                            <input type="hidden" name="action" value="clear">
                            <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                <i class="fas fa-times mr-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-800 font-medium">$<?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-800 font-medium"><?php echo $cartTotal >= 50 ? 'Free' : '$5.00'; ?></span>
                    </div>
                    <?php if ($cartTotal >= 50): ?>
                    <div class="flex justify-between text-green-600 text-sm">
                        <span>Free shipping applied</span>
                        <span>-$5.00</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex justify-between mb-6">
                    <span class="text-lg font-semibold text-gray-800">Total</span>
                    <span class="text-lg font-bold text-primary">$<?php echo number_format($cartTotal >= 50 ? $cartTotal : $cartTotal + 5, 2); ?></span>
                </div>
                
                <a href="<?php echo SITE_URL; ?>/pages/user/checkout.php" class="block w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-4 rounded-md transition duration-300 text-center">
                    Proceed to Checkout
                </a>
                
                <div class="mt-6">
                    <div class="flex items-center justify-center mb-4">
                        <span class="text-gray-600 text-sm">Secure Checkout</span>
                    </div>
                    <div class="flex justify-center space-x-2">
                        <i class="fab fa-cc-visa text-2xl text-blue-700"></i>
                        <i class="fab fa-cc-mastercard text-2xl text-red-500"></i>
                        <i class="fab fa-cc-amex text-2xl text-blue-500"></i>
                        <i class="fab fa-cc-paypal text-2xl text-blue-800"></i>
                        <i class="fab fa-cc-apple-pay text-2xl text-gray-800"></i>
                    </div>
                </div>
            </div>
            
            <!-- Promo Code -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Apply Promo Code</h3>
                <form class="flex">
                    <input type="text" placeholder="Enter promo code" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold px-4 py-2 rounded-r-md transition duration-300">
                        Apply
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    // Quantity buttons functionality
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.getAttribute('max'));
            
            if (this.classList.contains('decrease') && currentValue > 1) {
                input.value = currentValue - 1;
            } else if (this.classList.contains('increase') && currentValue < maxValue) {
                input.value = currentValue + 1;
            }
            
            // Auto-submit the form
            this.parentElement.querySelector('button[type="submit"]').click();
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
