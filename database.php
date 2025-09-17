<?php
// Database configuration
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

// Create tables if they don't exist
function createTables($pdo) {
    // Admin users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Products table
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        category VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        stock INT DEFAULT 0,
        image VARCHAR(255),
        description TEXT,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Categories table
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        image VARCHAR(255),
        description TEXT,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Orders table
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(100) NOT NULL,
        customer_email VARCHAR(100) NOT NULL,
        customer_phone VARCHAR(20),
        total_amount DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Order items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )");

    // Reviews table
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(100) NOT NULL,
        customer_username VARCHAR(100),
        rating INT CHECK (rating >= 1 AND rating <= 5),
        comment TEXT NOT NULL,
        profile_image VARCHAR(255),
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Site settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Insert default admin user (password: admin123)
    $stmt = $pdo->prepare("INSERT IGNORE INTO admin_users (username, email, password) VALUES (?, ?, ?)");
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt->execute(['admin', 'admin@xpressmart.lk', $hashedPassword]);

    // Insert default categories
    $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, image, description) VALUES (?, ?, ?)");
    $categories = [
        ['Fish & Meat', 'Images & Logos/s1.png', 'Fresh fish and quality meat products'],
        ['Fruits & Vegetables', 'Images & Logos/s2.png', 'Fresh fruits and organic vegetables'],
        ['Bakery Items & Cakes', 'Images & Logos/s3.png', 'Fresh baked goods and delicious cakes'],
        ['Dairy Products & Protein', 'Images & Logos/s4.png', 'Milk, cheese, yogurt and protein products'],
        ['Household Materials', 'Images & Logos/s5.png', 'Cleaning supplies and household essentials'],
        ['Processed Foods', 'Images & Logos/s6.png', 'Canned goods and processed food items']
    ];
    
    foreach ($categories as $category) {
        $stmt->execute($category);
    }

    // Insert sample products
    $stmt = $pdo->prepare("INSERT IGNORE INTO products (name, category, price, stock, image, description) VALUES (?, ?, ?, ?, ?, ?)");
    $products = [
        ['Hellmans Real Mayonnaise', 'Household Materials', 499.00, 45, 'Images & Logos/products/pr1.png', 'Premium quality mayonnaise for your kitchen'],
        ['Fresh Red Apples', 'Fruits & Vegetables', 350.00, 120, 'Images & Logos/products/apple.jpg', 'Fresh and crispy red apples'],
        ['Chicken Breast', 'Fish & Meat', 850.00, 25, 'Images & Logos/products/chicken.jpg', 'Fresh chicken breast, premium quality'],
        ['Whole Wheat Bread', 'Bakery Items & Cakes', 120.00, 80, 'Images & Logos/products/bread.jpg', 'Fresh baked whole wheat bread'],
        ['Fresh Milk 1L', 'Dairy Products & Protein', 180.00, 60, 'Images & Logos/products/milk.jpg', 'Fresh pasteurized milk'],
        ['Basmati Rice 5KG', 'Processed Foods', 1200.00, 35, 'Images & Logos/products/rice.jpg', 'Premium quality basmati rice']
    ];
    
    foreach ($products as $product) {
        $stmt->execute($product);
    }

    // Insert default site settings
    $stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
    $settings = [
        ['site_name', 'Xpress Mart'],
        ['site_tagline', 'WHERE FRESHNESS MEETS VALUES'],
        ['site_description', 'We believe in bringing you the freshest ingredients and quality products. Explore our wide selection of farm-fresh fruits and vegetables, premium meats, and artisanal goods, all hand-picked for you.'],
        ['contact_email', 'info@xpressmart.lk'],
        ['contact_phone', '+94 77 123 4567'],
        ['store_address', 'Kandy, Central Province, Sri Lanka']
    ];
    
    foreach ($settings as $setting) {
        $stmt->execute($setting);
    }

    echo "Database tables created successfully!<br>";
    echo "Default admin credentials:<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
}

// Initialize database
createTables($pdo);
?>