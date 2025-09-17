<?php
// Database connection only (without table creation)
$host = 'localhost';
$dbname = 'xpressmart_db';
$username = 'root'; // Change this to your database username
$password = '';     // Change this to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$type = $_GET['type'] ?? '';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;
$status = $_GET['status'] ?? null;

try {
    switch ($type) {
        case 'categories':
            echo json_encode(getCategories($status));
            break;
            
        case 'products':
            echo json_encode(getProducts($limit, $status));
            break;
            
        case 'reviews':
            echo json_encode(getReviews($limit, $status));
            break;
            
        case 'settings':
            echo json_encode(getSettings());
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid type parameter']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

function getCategories($status = null) {
    global $pdo;
    
    $sql = "SELECT * FROM categories";
    $params = [];
    
    if ($status) {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY name";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $categories];
}

function getProducts($limit = null, $status = null) {
    global $pdo;
    
    $sql = "SELECT * FROM products";
    $params = [];
    
    if ($status) {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $products];
}

function getReviews($limit = null, $status = null) {
    global $pdo;
    
    $sql = "SELECT * FROM reviews";
    $params = [];
    
    if ($status) {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['success' => true, 'data' => $reviews];
}

function getSettings() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    $settings = [];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return ['success' => true, 'data' => $settings];
}
?>