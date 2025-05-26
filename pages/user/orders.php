<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require login
requireLogin();

// Get user orders
$orders = getUserOrders($_SESSION['user_id']);

$pageTitle = 'My Orders';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Orders Page -->
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
                    <span class="text-primary">My Orders</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Orders</h1>
        <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="text-primary hover:text-primary-dark transition">
            <i class="fas fa-shopping-bag mr-1"></i> Continue Shopping
        </a>
    </div>
    
    <?php if (empty($orders)): ?>
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="text-6xl text-gray-300 mb-4">
            <i class="fas fa-box-open"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">No Orders Yet</h2>
        <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
        <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-md transition duration-300">
            Start Shopping
        </a>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
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
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#<?php echo $order['id']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></div>
                            <div class="text-xs text-gray-500"><?php echo date('h:i A', strtotime($order['created_at'])); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                            <span class="px-2 py-1 text-xs rounded-full <?php echo $statusClass; ?>">
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">$<?php echo number_format($order['total_amount'], 2); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="<?php echo SITE_URL; ?>/pages/user/order-details.php?id=<?php echo $order['id']; ?>" class="text-primary hover:text-primary-dark transition">
                                View Details
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
