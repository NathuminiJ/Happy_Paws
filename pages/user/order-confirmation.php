<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require login
requireLogin();

// Get order ID from URL
$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($orderId <= 0) {
    setFlashMessage('error', 'Invalid order');
    redirect(SITE_URL . '/pages/user/orders.php');
}

// Get order details
$order = getOrderDetails($orderId);

// Check if order exists and belongs to the current user
if (!$order || $order['user_id'] !== $_SESSION['user_id']) {
    setFlashMessage('error', 'Order not found');
    redirect(SITE_URL . '/pages/user/orders.php');
}

$pageTitle = 'Order Confirmation';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Order Confirmation Page -->
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
                    <span class="text-primary">Order Confirmation</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check text-2xl text-green-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Thank You for Your Order!</h1>
        <p class="text-gray-600 mb-4">Your order has been placed successfully.</p>
        <p class="text-gray-800 font-medium">Order #<?php echo $orderId; ?></p>
        <p class="text-gray-600 text-sm">A confirmation email has been sent to your email address.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Details</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="text-gray-800 font-medium">#<?php echo $orderId; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date:</span>
                    <span class="text-gray-800"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method:</span>
                    <span class="text-gray-800"><?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Status:</span>
                    <span class="px-2 py-1 text-xs rounded-full 
                        <?php
                        switch ($order['status']) {
                            case 'pending':
                                echo 'bg-yellow-100 text-yellow-800';
                                break;
                            case 'processing':
                                echo 'bg-blue-100 text-blue-800';
                                break;
                            case 'shipped':
                                echo 'bg-purple-100 text-purple-800';
                                break;
                            case 'delivered':
                                echo 'bg-green-100 text-green-800';
                                break;
                            case 'cancelled':
                                echo 'bg-red-100 text-red-800';
                                break;
                            default:
                                echo 'bg-gray-100 text-gray-800';
                        }
                        ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Shipping Address</h2>
            
            <div class="text-gray-700">
                <p><?php echo $_SESSION['username']; ?></p>
                <p class="whitespace-pre-line"><?php echo nl2br($order['shipping_address']); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <h2 class="text-xl font-semibold text-gray-800 p-6 border-b border-gray-200">Order Items</h2>
        
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
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <img class="h-16 w-16 rounded-md object-cover" 
                                         src="<?php echo !empty($item['image']) ? $item['image'] : 'https://via.placeholder.com/100x100?text=No+Image'; ?>" 
                                         alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">$<?php echo number_format($item['price'], 2); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo $item['quantity']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="text-sm font-medium text-gray-900">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">$<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Shipping</td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                            <?php echo $order['total_amount'] >= 50 ? 'Free' : '$5.00'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-base font-bold text-gray-800">Total</td>
                        <td class="px-6 py-4 text-right text-base font-bold text-primary">$<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- Next Steps -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">What's Next?</h2>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-primary-light text-primary font-bold">
                    1
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-800">Order Processing</h3>
                    <p class="text-gray-600">We're currently processing your order. You'll receive an email once it's ready for shipping.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-primary-light text-primary font-bold">
                    2
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-800">Shipping</h3>
                    <p class="text-gray-600">Your order will be shipped within 1-2 business days. You'll receive a tracking number via email.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-primary-light text-primary font-bold">
                    3
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-800">Delivery</h3>
                    <p class="text-gray-600">Standard delivery takes 3-5 business days. You can track your order status in your account.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <a href="<?php echo SITE_URL; ?>" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition duration-300 mb-4 sm:mb-0">
            <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
        </a>
        <a href="<?php echo SITE_URL; ?>/pages/user/orders.php" class="text-primary hover:text-primary-dark transition">
            <i class="fas fa-list-alt mr-2"></i> View All Orders
        </a>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
