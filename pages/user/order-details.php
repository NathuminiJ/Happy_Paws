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

$pageTitle = 'Order Details #' . $orderId;
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Order Details Page -->
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
                    <a href="<?php echo SITE_URL; ?>/pages/user/orders.php" class="text-gray-700 hover:text-primary transition">
                        My Orders
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-primary">Order #<?php echo $orderId; ?></span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Order #<?php echo $orderId; ?></h1>
        <a href="<?php echo SITE_URL; ?>/pages/user/orders.php" class="text-primary hover:text-primary-dark transition">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>
    </div>
    
    <!-- Order Status -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Order Status</h2>
                <?php
                $statusClass = '';
                switch ($order['status']) {
                    case 'pending':
                        $statusClass = 'bg-yellow-100 text-yellow-800';
                        break;
                    case 'processing':
                        $statusClass = 'bg-blue-100 text-blue-800';
                        break;
                    case 'shipped':
                        $statusClass = 'bg-purple-100 text-purple-800';
                        break;
                    case 'delivered':
                        $statusClass = 'bg-green-100 text-green-800';
                        break;
                    case 'cancelled':
                        $statusClass = 'bg-red-100 text-red-800';
                        break;
                }
                ?>
                <span class="px-3 py-1 text-sm rounded-full <?php echo $statusClass; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
            </div>
            
            <div class="mb-4 md:mb-0">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Order Date</h2>
                <p class="text-gray-700"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                <p class="text-gray-500 text-sm"><?php echo date('h:i A', strtotime($order['created_at'])); ?></p>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Payment Method</h2>
                <p class="text-gray-700"><?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Shipping Address</h2>
            
            <div class="text-gray-700">
                <p><?php echo $_SESSION['username']; ?></p>
                <p class="whitespace-pre-line"><?php echo nl2br($order['shipping_address']); ?></p>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-800 font-medium">$<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Shipping</span>
                    <span class="text-gray-800 font-medium">
                        <?php echo $order['total_amount'] >= 50 ? 'Free' : '$5.00'; ?>
                    </span>
                </div>
                <div class="flex justify-between pt-2">
                    <span class="text-gray-800 font-semibold">Total</span>
                    <span class="text-primary font-bold">$<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <h2 class="text-lg font-semibold text-gray-800 p-6 border-b border-gray-200">Order Items</h2>
        
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
                        <td class="px-6 py-4">
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
            </table>
        </div>
    </div>
    
    <!-- Order Timeline -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Order Timeline</h2>
        
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-5 top-0 h-full w-0.5 bg-gray-200"></div>
            
            <!-- Timeline Items -->
            <div class="space-y-8">
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center z-10">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-800">Order Placed</h3>
                        <p class="text-sm text-gray-500"><?php echo date('F j, Y h:i A', strtotime($order['created_at'])); ?></p>
                        <p class="mt-1 text-sm text-gray-600">Your order has been placed successfully.</p>
                    </div>
                </div>
                
                <?php if ($order['status'] != 'pending' && $order['status'] != 'cancelled'): ?>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center z-10">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-800">Order Processing</h3>
                        <p class="text-sm text-gray-500"><?php echo date('F j, Y h:i A', strtotime($order['updated_at'])); ?></p>
                        <p class="mt-1 text-sm text-gray-600">Your order is being processed.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($order['status'] == 'shipped' || $order['status'] == 'delivered'): ?>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center z-10">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-800">Order Shipped</h3>
                        <p class="text-sm text-gray-500"><?php echo date('F j, Y', strtotime('+2 days', strtotime($order['updated_at']))); ?></p>
                        <p class="mt-1 text-sm text-gray-600">Your order has been shipped. Tracking number: <span class="font-medium">TRK<?php echo rand(1000000, 9999999); ?></span></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($order['status'] == 'delivered'): ?>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center z-10">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-800">Order Delivered</h3>
                        <p class="text-sm text-gray-500"><?php echo date('F j, Y', strtotime('+5 days', strtotime($order['updated_at']))); ?></p>
                        <p class="mt-1 text-sm text-gray-600">Your order has been delivered successfully.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($order['status'] == 'cancelled'): ?>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center z-10">
                        <i class="fas fa-times text-red-600"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-800">Order Cancelled</h3>
                        <p class="text-sm text-gray-500"><?php echo date('F j, Y h:i A', strtotime($order['updated_at'])); ?></p>
                        <p class="mt-1 text-sm text-gray-600">Your order has been cancelled.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($order['status'] != 'delivered' && $order['status'] != 'cancelled'): ?>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center z-10">
                        <i class="fas fa-clock text-gray-500"></i>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-base font-medium text-gray-400">
                            <?php
                            if ($order['status'] == 'pending') {
                                echo 'Order Processing';
                            } elseif ($order['status'] == 'processing') {
                                echo 'Order Shipping';
                            } else {
                                echo 'Order Delivery';
                            }
                            ?>
                        </h3>
                        <p class="text-sm text-gray-500">Pending</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <a href="<?php echo SITE_URL; ?>/pages/user/orders.php" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition duration-300 mb-4 sm:mb-0">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
        
        <?php if ($order['status'] == 'pending'): ?>
        <button class="text-red-600 hover:text-red-900 transition">
            <i class="fas fa-times-circle mr-1"></i> Cancel Order
        </button>
        <?php elseif ($order['status'] == 'delivered'): ?>
        <button class="text-primary hover:text-primary-dark transition">
            <i class="fas fa-star mr-1"></i> Write a Review
        </button>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
