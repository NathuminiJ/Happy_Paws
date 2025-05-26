<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Require login
requireLogin();

// Get the action
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Handle different actions
switch ($action) {
    case 'add':
        // Add item to cart
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Validate input
        if ($productId <= 0) {
            setFlashMessage('error', 'Invalid product');
            redirect(SITE_URL . '/pages/user/products.php');
        }
        
        if ($quantity <= 0) {
            $quantity = 1;
        }
        
        // Get product to check if it exists and has enough stock
        $product = getProductById($productId);
        if (!$product) {
            setFlashMessage('error', 'Product not found');
            redirect(SITE_URL . '/pages/user/products.php');
        }
        
        if ($product['stock'] < $quantity) {
            setFlashMessage('error', 'Not enough stock available. Only ' . $product['stock'] . ' items left.');
            
            // Redirect back to the product page or referer
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect(SITE_URL . '/pages/user/product-details.php?slug=' . $product['slug']);
            }
        }
        
        // Add to cart
        if (addToCart($_SESSION['user_id'], $productId, $quantity)) {
            setFlashMessage('success', 'Product added to cart');
        } else {
            setFlashMessage('error', 'Failed to add product to cart');
        }
        
        // Redirect to cart page or back to previous page
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(SITE_URL . '/pages/user/cart.php');
        }
        break;
        
    case 'update':
        // Update cart item quantity
        $cartId = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Validate input
        if ($cartId <= 0) {
            setFlashMessage('error', 'Invalid cart item');
            redirect(SITE_URL . '/pages/user/cart.php');
        }
        
        if ($quantity <= 0) {
            // If quantity is 0 or negative, remove the item
            if (removeFromCart($cartId)) {
                setFlashMessage('success', 'Item removed from cart');
            } else {
                setFlashMessage('error', 'Failed to remove item from cart');
            }
        } else {
            // Update quantity
            if (updateCartItem($cartId, $quantity)) {
                setFlashMessage('success', 'Cart updated');
            } else {
                setFlashMessage('error', 'Failed to update cart');
            }
        }
        
        redirect(SITE_URL . '/pages/user/cart.php');
        break;
        
    case 'remove':
        // Remove item from cart
        $cartId = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
        
        // Validate input
        if ($cartId <= 0) {
            setFlashMessage('error', 'Invalid cart item');
            redirect(SITE_URL . '/pages/user/cart.php');
        }
        
        // Remove from cart
        if (removeFromCart($cartId)) {
            setFlashMessage('success', 'Item removed from cart');
        } else {
            setFlashMessage('error', 'Failed to remove item from cart');
        }
        
        redirect(SITE_URL . '/pages/user/cart.php');
        break;
        
    case 'clear':
        // Clear the entire cart
        if (clearCart($_SESSION['user_id'])) {
            setFlashMessage('success', 'Cart cleared');
        } else {
            setFlashMessage('error', 'Failed to clear cart');
        }
        
        redirect(SITE_URL . '/pages/user/cart.php');
        break;
        
    default:
        // Invalid action
        setFlashMessage('error', 'Invalid action');
        redirect(SITE_URL . '/pages/user/cart.php');
}
