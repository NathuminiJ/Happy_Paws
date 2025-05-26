<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require admin privileges
requireAdmin();

// Get statistics
$db = getDB();

// Total products
$result = $db->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $result->fetch_assoc()['total'];

// Total users
$result = $db->query("SELECT COUNT(*) as total FROM users WHERE user_type = 'user'");
$totalUsers = $result->fetch_assoc()['total'];

// Total orders
$result = $db->query("SELECT COUNT(*) as total FROM orders");
$totalOrders = $result->fetch_assoc()['total'];

// Total revenue
$result = $db->query("SELECT SUM(total_amount) as total FROM orders");
$totalRevenue = $result->fetch_assoc()['total'] ?? 0;

// Recent orders
$result = $db->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5");
$recentOrders = [];
while ($row = $result->fetch_assoc()) {
    $recentOrders[] = $row;
}

// Low stock products
$result = $db->query("SELECT * FROM products WHERE stock < 10 ORDER BY stock ASC LIMIT 5");
$lowStockProducts = [];
while ($row = $result->fetch_assoc()) {
    $lowStockProducts[] = $row;
}

$pageTitle = 'Admin Dashboard';
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Old School Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
        
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
                <li class="px-4 py-3 old-sidebar-item active">
                    <a href="<?php echo ADMIN_URL; ?>/dashboard.php" class="flex items-center">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="px-4 py-3 old-sidebar-item">
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
        
        <h1 class="text-3xl font-bold text-oldschool-text mb-6 old-title typewriter">Admin Dashboard</h1>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-oldschool-light old-card p-6 transform rotate-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary text-white">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-oldschool-text font-courier">Total Products</h3>
                        <p class="text-2xl font-bold text-primary font-courier"><?php echo $totalProducts; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Total Users -->
            <div class="bg-oldschool-light old-card p-6 transform -rotate-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary text-white">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-oldschool-text font-courier">Total Users</h3>
                        <p class="text-2xl font-bold text-primary font-courier"><?php echo $totalUsers; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Total Orders -->
            <div class="bg-oldschool-light old-card p-6 transform rotate-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary text-white">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-oldschool-text font-courier">Total Orders</h3>
                        <p class="text-2xl font-bold text-primary font-courier"><?php echo $totalOrders; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Total Revenue -->
            <div class="bg-oldschool-light old-card p-6 transform -rotate-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary text-white">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-oldschool-text font-courier">Total Revenue</h3>
                        <p class="text-2xl font-bold text-primary font-courier">$<?php echo number_format($totalRevenue, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-oldschool-light old-card p-6">
                <h3 class="text-xl font-bold text-oldschool-text mb-4 old-title font-courier">Sales Overview</h3>
                <div style="height: 300px; position: relative;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            
            <div class="bg-oldschool-light old-card p-6">
                <h3 class="text-xl font-bold text-oldschool-text mb-4 old-title font-courier">Categories Distribution</h3>
                <div style="height: 300px; position: relative;">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-oldschool-light old-card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-oldschool-text old-title font-courier">Recent Orders</h3>
                    <a href="<?php echo ADMIN_URL; ?>/orders.php" class="text-primary hover:text-primary-dark transition old-button px-3 py-1">
                        View All
                    </a>
                </div>
                
                <?php if (empty($recentOrders)): ?>
                <p class="text-oldschool-text font-courier">No orders yet.</p>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full old-border">
                        <thead>
                            <tr class="bg-primary bg-opacity-20">
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Order ID</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Customer</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Amount</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Status</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dashed divide-primary">
                            <?php foreach ($recentOrders as $order): ?>
                            <tr class="hover:bg-oldschool-highlight">
                                <td class="py-3 px-3 whitespace-nowrap font-courier">
                                    <a href="<?php echo ADMIN_URL; ?>/order-details.php?id=<?php echo $order['id']; ?>" class="text-primary hover:text-primary-dark font-bold">
                                        #<?php echo $order['id']; ?>
                                    </a>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap font-courier"><?php echo $order['username']; ?></td>
                                <td class="py-3 px-3 whitespace-nowrap font-courier">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <?php
                                    $statusClass = '';
                                    switch ($order['status']) {
                                        case 'pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-800 old-border';
                                            break;
                                        case 'processing':
                                            $statusClass = 'bg-blue-100 text-blue-800 old-border';
                                            break;
                                        case 'shipped':
                                            $statusClass = 'bg-purple-100 text-purple-800 old-border';
                                            break;
                                        case 'delivered':
                                            $statusClass = 'bg-green-100 text-green-800 old-border';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'bg-red-100 text-red-800 old-border';
                                            break;
                                    }
                                    ?>
                                    <span class="px-2 py-1 text-xs font-courier font-bold transform rotate-1 inline-block <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap font-courier"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="bg-oldschool-light old-card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-oldschool-text old-title font-courier">Low Stock Products</h3>
                    <a href="<?php echo ADMIN_URL; ?>/products.php" class="text-primary hover:text-primary-dark transition old-button px-3 py-1">
                        View All
                    </a>
                </div>
                
                <?php if (empty($lowStockProducts)): ?>
                <p class="text-oldschool-text font-courier">No low stock products.</p>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full old-border">
                        <thead>
                            <tr class="bg-primary bg-opacity-20">
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Product</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Price</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Stock</th>
                                <th class="py-2 px-3 text-left text-xs font-bold text-oldschool-text uppercase tracking-wider font-courier">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dashed divide-primary">
                            <?php foreach ($lowStockProducts as $product): ?>
                            <tr class="hover:bg-oldschool-highlight">
                                <td class="py-3 px-3 font-courier">
                                    <a href="<?php echo ADMIN_URL; ?>/edit-product.php?id=<?php echo $product['id']; ?>" class="text-primary hover:text-primary-dark font-bold">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap font-courier">$<?php echo number_format($product['price'], 2); ?></td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-courier font-bold transform rotate-1 inline-block old-border <?php echo $product['stock'] <= 5 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                        <?php echo $product['stock']; ?> left
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <a href="<?php echo ADMIN_URL; ?>/edit-product.php?id=<?php echo $product['id']; ?>" class="old-button px-2 py-1 inline-block">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <!-- JavaScript for Charts -->
    <script>
        // Add typewriter effect to titles
        document.addEventListener('DOMContentLoaded', function() {
            // Apply old-school styles to chart
            Chart.defaults.font.family = "'Courier Prime', monospace";
            Chart.defaults.color = '#654321';
            
            // Add paper texture to charts
            const addPaperTexture = () => {
                const charts = document.querySelectorAll('canvas');
                charts.forEach(chart => {
                    const parent = chart.parentElement;
                    parent.style.backgroundColor = '#F5F5DC';
                    parent.style.padding = '10px';
                    parent.style.border = '2px solid #A0522D';
                });
            };
            
            setTimeout(addPaperTexture, 500);
            
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Sales',
                        data: [1200, 1900, 3000, 5000, 2000, 3000, 4500, 5500, 6500, 7000, 8000, 9000],
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        borderColor: 'rgba(236, 72, 153, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 10000,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            },
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 10,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(236, 72, 153, 1)',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            });
            
            // Categories Chart
            const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
            const categoriesChart = new Chart(categoriesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Dog Supplies', 'Cat Supplies', 'Small Pet Supplies', 'Fish Supplies', 'Pet Food'],
                    datasets: [{
                        data: [30, 25, 20, 15, 10],
                        backgroundColor: [
                            'rgba(236, 72, 153, 0.7)',
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(139, 92, 246, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    layout: {
                        padding: 20
                    },
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                boxWidth: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 10,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(236, 72, 153, 1)',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
