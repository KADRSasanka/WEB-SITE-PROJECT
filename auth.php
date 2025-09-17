<?php
session_start();

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

// Login function
function login($username, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_email'] = $user['email'];
            
            return ['success' => true, 'message' => 'Login successful'];
        } else {
            return ['success' => false, 'message' => 'Invalid username or password'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// Logout function
function logout() {
    session_destroy();
    header('Location: index.html');
    exit;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Require login (use this at the top of admin pages)
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.html#login');
        exit;
    }
}

// Handle AJAX login requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'login':
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($username) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Username and password are required']);
                exit;
            }
            
            $result = login($username, $password);
            echo json_encode($result);
            exit;
            
        case 'logout':
            logout();
            break;
            
        case 'check_session':
            echo json_encode(['logged_in' => isLoggedIn()]);
            exit;
    }
}

// Handle admin access check
if (isset($_GET['check_admin'])) {
    header('Content-Type: application/json');
    echo json_encode(['logged_in' => isLoggedIn()]);
    exit;
}
?>