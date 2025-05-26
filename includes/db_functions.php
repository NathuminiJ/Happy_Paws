<?php
require_once __DIR__ . '/../config/config.php';

// Product functions
function getAllProducts($limit = null, $category = null) {
    $db = getDB();
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id";
    
    if ($category) {
        $sql .= " WHERE c.slug = ?";
    }
    
    $sql .= " ORDER BY p.created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
    }
    
    $stmt = $db->prepare($sql);
    
    if ($category && $limit) {
        $stmt->bind_param("si", $category, $limit);
    } elseif ($category) {
        $stmt->bind_param("s", $category);
    } elseif ($limit) {
        $stmt->bind_param("i", $limit);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    return $products;
}

function getProductById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function getProductBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function createProduct($data) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO products (name, slug, description, price, sale_price, image, stock, category_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddsii", 
        $data['name'], 
        $data['slug'], 
        $data['description'], 
        $data['price'], 
        $data['sale_price'], 
        $data['image'], 
        $data['stock'], 
        $data['category_id']
    );
    
    if ($stmt->execute()) {
        return $db->insert_id;
    }
    
    return false;
}

function updateProduct($id, $data) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE products 
                           SET name = ?, slug = ?, description = ?, price = ?, 
                               sale_price = ?, image = ?, stock = ?, category_id = ? 
                           WHERE id = ?");
    $stmt->bind_param("sssddsiii", 
        $data['name'], 
        $data['slug'], 
        $data['description'], 
        $data['price'], 
        $data['sale_price'], 
        $data['image'], 
        $data['stock'], 
        $data['category_id'],
        $id
    );
    
    return $stmt->execute();
}

function deleteProduct($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

// Category functions
function getAllCategories() {
    $db = getDB();
    $result = $db->query("SELECT * FROM categories ORDER BY name");
    
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    
    return $categories;
}

function getCategoryBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Cart functions
function addToCart($userId, $productId, $quantity = 1) {
    $db = getDB();
    
    // Check if product already in cart
    $stmt = $db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update quantity
        $cartItem = $result->fetch_assoc();
        $newQuantity = $cartItem['quantity'] + $quantity;
        
        $stmt = $db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $newQuantity, $cartItem['id']);
        
        return $stmt->execute();
    } else {
        // Insert new cart item
        $stmt = $db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        
        return $stmt->execute();
    }
}

function updateCartItem($cartId, $quantity) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $cartId);
    
    return $stmt->execute();
}

function removeFromCart($cartId) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $cartId);
    
    return $stmt->execute();
}

function getCartItems($userId) {
    $db = getDB();
    $stmt = $db->prepare("SELECT c.*, p.name, p.price, p.image, p.stock 
                           FROM cart c 
                           JOIN products p ON c.product_id = p.id 
                           WHERE c.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $row['total'] = $row['price'] * $row['quantity'];
        $cartItems[] = $row;
    }
    
    return $cartItems;
}

function getCartTotal($userId) {
    $db = getDB();
    $stmt = $db->prepare("SELECT SUM(p.price * c.quantity) as total 
                           FROM cart c 
                           JOIN products p ON c.product_id = p.id 
                           WHERE c.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['total'] ?? 0;
}

function clearCart($userId) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    
    return $stmt->execute();
}

// Order functions
function createOrder($userId, $totalAmount, $shippingAddress, $paymentMethod) {
    $db = getDB();
    
    // Start transaction
    $db->begin_transaction();
    
    try {
        // Create order
        $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, payment_method) 
                             VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $userId, $totalAmount, $shippingAddress, $paymentMethod);
        $stmt->execute();
        
        $orderId = $db->insert_id;
        
        // Get cart items
        $cartItems = getCartItems($userId);
        
        // Add order items
        foreach ($cartItems as $item) {
            $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                 VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
            $stmt->execute();
            
            // Update product stock
            $newStock = $item['stock'] - $item['quantity'];
            $stmt = $db->prepare("UPDATE products SET stock = ? WHERE id = ?");
            $stmt->bind_param("ii", $newStock, $item['product_id']);
            $stmt->execute();
        }
        
        // Clear cart
        clearCart($userId);
        
        // Commit transaction
        $db->commit();
        
        return $orderId;
    } catch (Exception $e) {
        // Rollback transaction on error
        $db->rollback();
        return false;
    }
}

function getUserOrders($userId) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    
    return $orders;
}

function getOrderDetails($orderId) {
    $db = getDB();
    
    // Get order
    $stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $order = $result->fetch_assoc();
    
    // Get order items
    $stmt = $db->prepare("SELECT oi.*, p.name, p.image 
                           FROM order_items oi 
                           JOIN products p ON oi.product_id = p.id 
                           WHERE oi.order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    $order['items'] = $items;
    
    return $order;
}

function updateOrderStatus($orderId, $status) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    
    return $stmt->execute();
}

// Search function
function searchProducts($query) {
    $db = getDB();
    $searchTerm = "%$query%";
    $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.name LIKE ? OR p.description LIKE ?
                           ORDER BY p.created_at DESC");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    return $products;
}
