<?php
require_once 'auth.php';

// Database connection is now included from auth.php

// Set content type to JSON
header('Content-Type: application/json');

// Enable CORS for local development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Check if user is logged in for all API requests
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'get_stats':
            echo json_encode(getStats());
            break;
            
        case 'get_products':
            echo json_encode(getProducts());
            break;
            
        case 'add_product':
            echo json_encode(addProduct());
            break;
            
        case 'update_product':
            echo json_encode(updateProduct());
            break;
            
        case 'delete_product':
            echo json_encode(deleteProduct());
            break;
            
        case 'get_orders':
            echo json_encode(getOrders());
            break;
            
        case 'update_order_status':
            echo json_encode(updateOrderStatus());
            break;
            
        case 'get_customers':
            echo json_encode(getCustomers());
            break;
            
        case 'get_categories':
            echo json_encode(getCategories());
            break;
            
        case 'add_category':
            echo json_encode(addCategory());
            break;
            
        case 'get_reviews':
            echo json_encode(getReviews());
            break;
            
        case 'add_review':
            echo json_encode(addReview());
            break;
            
        case 'update_review_status':
            echo json_encode(updateReviewStatus());
            break;
            
        case 'delete_review':
            echo json_encode(deleteReview());
            break;
            
        case 'get_settings':
            echo json_encode(getSettings());
            break;
            
        case 'update_settings':
            echo json_encode(updateSettings());
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

// Dashboard statistics
function getStats() {
    global $pdo;
    
    $stats = [];
    
    // Total products
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE status = 'active'");
    $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Total orders
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Total revenue
    $stmt = $pdo->query("SELECT SUM(total_amount) as revenue FROM orders WHERE status = 'completed'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['total_revenue'] = $result['revenue'] ?? 0;
    
    // Low stock alerts
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE stock < 10 AND status = 'active'");
    $stats['low_stock_count'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Recent orders
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()");
    $stats['today_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    return ['success' => true, 'data' => $stats];
}

// Products management
function getProducts() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $products];
}

function addProduct() {
    global $pdo;
    
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    
    if (empty($name) || empty($category) || $price <= 0) {
        return ['success' => false, 'message' => 'Name, category, and valid price are required'];
    }
    
    $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$name, $category, $price, $stock, $description, $image]);
    
    if ($result) {
        return ['success' => true, 'message' => 'Product added successfully', 'id' => $pdo->lastInsertId()];
    } else {
        return ['success' => false, 'message' => 'Failed to add product'];
    }
}

function updateProduct() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'active';
    
    if (!$id || empty($name) || empty($category) || $price <= 0) {
        return ['success' => false, 'message' => 'Invalid product data'];
    }
    
    $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock = ?, description = ?, status = ? WHERE id = ?");
    $result = $stmt->execute([$name, $category, $price, $stock, $description, $status, $id]);
    
    return ['success' => $result, 'message' => $result ? 'Product updated successfully' : 'Failed to update product'];
}

function deleteProduct() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    
    if (!$id) {
        return ['success' => false, 'message' => 'Product ID is required'];
    }
    
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $result = $stmt->execute([$id]);
    
    return ['success' => $result, 'message' => $result ? 'Product deleted successfully' : 'Failed to delete product'];
}

// Orders management
function getOrders() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT o.*, COUNT(oi.id) as item_count 
                        FROM orders o 
                        LEFT JOIN order_items oi ON o.id = oi.order_id 
                        GROUP BY o.id 
                        ORDER BY o.created_at DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $orders];
}

function updateOrderStatus() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    $status = $_POST['status'] ?? '';
    
    if (!$id || empty($status)) {
        return ['success' => false, 'message' => 'Order ID and status are required'];
    }
    
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $result = $stmt->execute([$status, $id]);
    
    return ['success' => $result, 'message' => $result ? 'Order status updated' : 'Failed to update order'];
}

// Customers (from orders)
function getCustomers() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT customer_name as name, customer_email as email, customer_phone as phone,
                        COUNT(*) as total_orders, SUM(total_amount) as total_spent,
                        MAX(created_at) as last_order
                        FROM orders 
                        GROUP BY customer_email 
                        ORDER BY total_spent DESC");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $customers];
}

// Categories management
function getCategories() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $categories];
}

function addCategory() {
    global $pdo;
    
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    
    if (empty($name)) {
        return ['success' => false, 'message' => 'Category name is required'];
    }
    
    $stmt = $pdo->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
    $result = $stmt->execute([$name, $description, $image]);
    
    return ['success' => $result, 'message' => $result ? 'Category added successfully' : 'Failed to add category'];
}

// Reviews management
function getReviews() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $reviews];
}

function addReview() {
    global $pdo;
    
    $name = $_POST['customer_name'] ?? '';
    $username = $_POST['customer_username'] ?? '';
    $rating = $_POST['rating'] ?? 0;
    $comment = $_POST['comment'] ?? '';
    $profile_image = $_POST['profile_image'] ?? 'Images & Logos/dp (2).png';
    
    if (empty($name) || empty($comment) || $rating < 1 || $rating > 5) {
        return ['success' => false, 'message' => 'Name, comment, and valid rating (1-5) are required'];
    }
    
    $stmt = $pdo->prepare("INSERT INTO reviews (customer_name, customer_username, rating, comment, profile_image) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([$name, $username, $rating, $comment, $profile_image]);
    
    return ['success' => $result, 'message' => $result ? 'Review added successfully' : 'Failed to add review'];
}

function updateReviewStatus() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    $status = $_POST['status'] ?? 'active';
    
    if (!$id) {
        return ['success' => false, 'message' => 'Review ID is required'];
    }
    
    $stmt = $pdo->prepare("UPDATE reviews SET status = ? WHERE id = ?");
    $result = $stmt->execute([$status, $id]);
    
    return ['success' => $result, 'message' => $result ? 'Review status updated' : 'Failed to update review'];
}

function deleteReview() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    
    if (!$id) {
        return ['success' => false, 'message' => 'Review ID is required'];
    }
    
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    $result = $stmt->execute([$id]);
    
    return ['success' => $result, 'message' => $result ? 'Review deleted successfully' : 'Failed to delete review'];
}

// Settings management
function getSettings() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    $settings = [];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return ['success' => true, 'data' => $settings];
}

function updateSettings() {
    global $pdo;
    
    $settings = $_POST['settings'] ?? [];
    
    if (empty($settings)) {
        return ['success' => false, 'message' => 'No settings provided'];
    }
    
    $pdo->beginTransaction();
    
    try {
        $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
        
        foreach ($settings as $key => $value) {
            $stmt->execute([$value, $key]);
        }
        
        $pdo->commit();
        return ['success' => true, 'message' => 'Settings updated successfully'];
    } catch (Exception $e) {
        $pdo->rollback();
        return ['success' => false, 'message' => 'Failed to update settings: ' . $e->getMessage()];
    }
}
?>