<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require login
requireLogin();

// Get cart items
$cartItems = getCartItems($_SESSION['user_id']);
$cartTotal = getCartTotal($_SESSION['user_id']);

// Redirect if cart is empty
if (empty($cartItems)) {
    setFlashMessage('error', 'Your cart is empty');
    redirect(SITE_URL . '/pages/user/cart.php');
}

// Process checkout form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $shippingAddress = sanitize($_POST['address'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['zip_code'] . ', ' . $_POST['country']);
    $paymentMethod = sanitize($_POST['payment_method']);
    
    // Validate input
    $errors = [];
    if (empty($_POST['first_name'])) {
        $errors[] = 'First name is required';
    }
    
    if (empty($_POST['last_name'])) {
        $errors[] = 'Last name is required';
    }
    
    if (empty($_POST['email'])) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($_POST['address'])) {
        $errors[] = 'Address is required';
    }
    
    if (empty($_POST['city'])) {
        $errors[] = 'City is required';
    }
    
    if (empty($_POST['state'])) {
        $errors[] = 'State is required';
    }
    
    if (empty($_POST['zip_code'])) {
        $errors[] = 'ZIP code is required';
    }
    
    if (empty($_POST['country'])) {
        $errors[] = 'Country is required';
    }
    
    if (empty($_POST['payment_method'])) {
        $errors[] = 'Payment method is required';
    }
    
    // If no errors, create order
    if (empty($errors)) {
        $totalAmount = $cartTotal >= 50 ? $cartTotal : $cartTotal + 5; // Add shipping if less than $50
        
        $orderId = createOrder($_SESSION['user_id'], $totalAmount, $shippingAddress, $paymentMethod);
        
        if ($orderId) {
            setFlashMessage('success', 'Order placed successfully!');
            redirect(SITE_URL . '/pages/user/order-confirmation.php?id=' . $orderId);
        } else {
            $checkoutError = 'Failed to place order. Please try again.';
        }
    }
}

$pageTitle = 'Checkout';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Checkout Page -->
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
                    <a href="<?php echo SITE_URL; ?>/pages/user/cart.php" class="text-gray-700 hover:text-primary transition">
                        Shopping Cart
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-primary">Checkout</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>
    
    <!-- Error Messages -->
    <?php if (isset($checkoutError)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
        <div class="flex items-center">
            <i class="fas fa-times-circle mr-2"></i>
            <span><?php echo $checkoutError; ?></span>
        </div>
    </div>
    <?php endif; ?>
    
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
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Checkout Form -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="<?php echo SITE_URL; ?>/pages/user/checkout.php" method="POST">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing & Shipping Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">First Name *</label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 text-sm font-medium mb-2">Street Address *</label>
                        <input type="text" id="address" name="address" 
                               value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="address2" class="block text-gray-700 text-sm font-medium mb-2">Apartment, suite, etc. (optional)</label>
                        <input type="text" id="address2" name="address2" 
                               value="<?php echo isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="city" class="block text-gray-700 text-sm font-medium mb-2">City *</label>
                            <input type="text" id="city" name="city" 
                                   value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        <div>
                            <label for="state" class="block text-gray-700 text-sm font-medium mb-2">State/Province *</label>
                            <input type="text" id="state" name="state" 
                                   value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="zip_code" class="block text-gray-700 text-sm font-medium mb-2">ZIP/Postal Code *</label>
                            <input type="text" id="zip_code" name="zip_code" 
                                   value="<?php echo isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required>
                        </div>
                        <div>
                            <label for="country" class="block text-gray-700 text-sm font-medium mb-2">Country *</label>
                            <select id="country" name="country" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                <option value="">Select Country</option>
                                <option value="United States" <?php echo (isset($_POST['country']) && $_POST['country'] === 'United States') ? 'selected' : ''; ?>>United States</option>
                                <option value="Canada" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Canada') ? 'selected' : ''; ?>>Canada</option>
                                <option value="United Kingdom" <?php echo (isset($_POST['country']) && $_POST['country'] === 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
                                <option value="Australia" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Australia') ? 'selected' : ''; ?>>Australia</option>
                                <option value="India" <?php echo (isset($_POST['country']) && $_POST['country'] === 'India') ? 'selected' : ''; ?>>India</option>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="order_notes" class="block text-gray-700 text-sm font-medium mb-2">Order Notes (optional)</label>
                        <textarea id="order_notes" name="order_notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                  placeholder="Notes about your order, e.g. special delivery instructions"><?php echo isset($_POST['order_notes']) ? htmlspecialchars($_POST['order_notes']) : ''; ?></textarea>
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Method</h2>
                    
                    <div class="mb-6 space-y-3">
                        <div class="flex items-center">
                            <input type="radio" id="payment_credit_card" name="payment_method" value="credit_card" 
                                   <?php echo (!isset($_POST['payment_method']) || $_POST['payment_method'] === 'credit_card') ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                            <label for="payment_credit_card" class="ml-2 block text-gray-700">
                                Credit Card
                                <span class="ml-2 inline-flex items-center">
                                    <i class="fab fa-cc-visa text-blue-700 mr-1"></i>
                                    <i class="fab fa-cc-mastercard text-red-500 mr-1"></i>
                                    <i class="fab fa-cc-amex text-blue-500"></i>
                                </span>
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="payment_paypal" name="payment_method" value="paypal" 
                                   <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] === 'paypal') ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                            <label for="payment_paypal" class="ml-2 block text-gray-700">
                                PayPal
                                <i class="fab fa-paypal text-blue-800 ml-2"></i>
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="payment_cash" name="payment_method" value="cash_on_delivery" 
                                   <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] === 'cash_on_delivery') ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                            <label for="payment_cash" class="ml-2 block text-gray-700">
                                Cash on Delivery
                                <i class="fas fa-money-bill-wave text-green-600 ml-2"></i>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Credit Card Details (shown only when credit card is selected) -->
                    <div id="credit-card-details" class="border border-gray-200 rounded-md p-4 mb-6 <?php echo (!isset($_POST['payment_method']) || $_POST['payment_method'] === 'credit_card') ? '' : 'hidden'; ?>">
                        <div class="mb-4">
                            <label for="card_number" class="block text-gray-700 text-sm font-medium mb-2">Card Number</label>
                            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="expiry_date" class="block text-gray-700 text-sm font-medium mb-2">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label for="cvv" class="block text-gray-700 text-sm font-medium mb-2">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label for="card_name" class="block text-gray-700 text-sm font-medium mb-2">Name on Card</label>
                            <input type="text" id="card_name" name="card_name" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms" required 
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-gray-700 text-sm">
                                I agree to the <a href="#" class="text-primary hover:underline">Terms and Conditions</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <a href="<?php echo SITE_URL; ?>/pages/user/cart.php" class="text-primary hover:text-primary-dark transition">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Cart
                        </a>
                        <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-md transition duration-300">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="flex justify-between py-2">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-800"><?php echo $item['quantity']; ?> ×</span>
                            <span class="ml-2 text-gray-600 truncate max-w-[150px]"><?php echo $item['name']; ?></span>
                        </div>
                        <span class="text-gray-800">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
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
                
                <div class="bg-gray-100 p-4 rounded-md mb-4">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                        <span>Secure Checkout</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Your payment information is processed securely.</p>
                </div>
                
                <div class="text-sm text-gray-600">
                    <p>By completing your purchase, you agree to our <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide credit card details based on payment method selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardDetails = document.getElementById('credit-card-details');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardDetails.classList.remove('hidden');
            } else {
                creditCardDetails.classList.add('hidden');
            }
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
