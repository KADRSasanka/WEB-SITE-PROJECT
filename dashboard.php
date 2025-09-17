<?php
// Start session and check authentication
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Require login (redirect if not logged in)
if (!isLoggedIn()) {
    header('Location: index.html#login');
    exit;
}

// Get current admin info
$adminUsername = $_SESSION['admin_username'];
$adminEmail = $_SESSION['admin_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Xpress Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            color: #27ae60;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(39, 174, 96, 0.2);
            border-left-color: #27ae60;
            transform: translateX(5px);
        }

        .sidebar-menu i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .toggle-btn {
            position: absolute;
            top: 20px;
            right: -15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(39, 174, 96, 0.3);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .dashboard-header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h1 {
            color: #2c3e50;
            font-size: 2rem;
            display: flex;
            align-items: center;
        }

        .dashboard-header h1 i {
            margin-right: 15px;
            color: #27ae60;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 1.5rem;
            color: white;
        }

        .stat-info h3 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #7f8c8d;
            font-weight: 500;
        }

        /* Content Sections */
        .content-section {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h2 {
            color: #2c3e50;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-header i {
            margin-right: 10px;
            color: #27ae60;
        }

        .action-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #2ecc71;
            transform: translateY(-2px);
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .data-table th {
            background: #34495e;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background: #d5f4e6;
            color: #27ae60;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }

        .btn-small {
            padding: 5px 15px;
            font-size: 0.8rem;
            margin-right: 5px;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f39c12;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #e74c3c;
        }

        .loading {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #27ae60;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-menu span {
                display: none;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .dashboard-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="sidebar-header">
                <h2>XpressMart</h2>
                <p>Admin Panel</p>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="#" class="menu-link active" data-section="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="products">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="orders">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="customers">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="categories">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="reviews">
                    <i class="fas fa-star"></i>
                    <span>Reviews</span>
                </a></li>
                <li><a href="#" class="menu-link" data-section="settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <h1><i class="fas fa-tachometer-alt"></i>Admin Dashboard</h1>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($adminUsername, 0, 1)); ?></div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: #2c3e50;"><?php echo htmlspecialchars($adminUsername); ?></p>
                        <p style="margin: 0; font-size: 0.8rem; color: #7f8c8d;">Administrator</p>
                    </div>
                    <button class="logout-btn" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </div>
            </header>

            <!-- Dashboard Section -->
            <div id="dashboard-section" class="content-section active">
                <div class="stats-grid">
                    <div class="stat-card" style="--card-color: #3498db; --card-color-light: #5dade2;">
                        <div class="stat-icon" style="background: linear-gradient(45deg, #3498db, #5dade2);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalProducts">-</h3>
                            <p>Total Products</p>
                        </div>
                    </div>
                    <div class="stat-card" style="--card-color: #e74c3c; --card-color-light: #ec7063;">
                        <div class="stat-icon" style="background: linear-gradient(45deg, #e74c3c, #ec7063);">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalOrders">-</h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="stat-card" style="--card-color: #27ae60; --card-color-light: #58d68d;">
                        <div class="stat-icon" style="background: linear-gradient(45deg, #27ae60, #58d68d);">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalRevenue">-</h3>
                            <p>Total Revenue</p>
                        </div>
                    </div>
                    <div class="stat-card" style="--card-color: #f39c12; --card-color-light: #f7dc6f;">
                        <div class="stat-icon" style="background: linear-gradient(45deg, #f39c12, #f7dc6f);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="lowStock">-</h3>
                            <p>Low Stock Items</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div id="products-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-box"></i>Products Management</h2>
                    <button class="action-btn" onclick="openAddProductModal()">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </div>
                
                <table class="data-table" id="productsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <tr><td colspan="7" style="text-align: center;">Loading products...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Orders Section -->
            <div id="orders-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-shopping-cart"></i>Orders Management</h2>
                </div>
                
                <table class="data-table" id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <tr><td colspan="7" style="text-align: center;">Loading orders...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Customers Section -->
            <div id="customers-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-users"></i>Customers Management</h2>
                </div>
                
                <table class="data-table" id="customersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        <tr><td colspan="6" style="text-align: center;">Loading customers...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Categories Section -->
            <div id="categories-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-tags"></i>Categories Management</h2>
                    <button class="action-btn" onclick="openAddCategoryModal()">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                </div>
                
                <table class="data-table" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <tr><td colspan="5" style="text-align: center;">Loading categories...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Reviews Section -->
            <div id="reviews-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-star"></i>Reviews Management</h2>
                    <button class="action-btn" onclick="openAddReviewModal()">
                        <i class="fas fa-plus"></i> Add Review
                    </button>
                </div>
                
                <table class="data-table" id="reviewsTable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reviewsTableBody">
                        <tr><td colspan="6" style="text-align: center;">Loading reviews...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Settings Section -->
            <div id="settings-section" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-cog"></i>Settings</h2>
                </div>
                <form id="settingsForm">
                    <div class="form-group">
                        <label>Store Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name">
                    </div>
                    <div class="form-group">
                        <label>Store Tagline</label>
                        <input type="text" class="form-control" id="site_tagline" name="site_tagline">
                    </div>
                    <div class="form-group">
                        <label>Store Description</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email">
                    </div>
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone">
                    </div>
                    <div class="form-group">
                        <label>Store Address</label>
                        <input type="text" class="form-control" id="store_address" name="store_address">
                    </div>
                    <button type="submit" class="action-btn">Save Settings</button>
                </form>
            </div>
        </main>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="productModalTitle">Add Product</h2>
                <span class="close" onclick="closeModal('productModal')">&times;</span>
            </div>
            <form id="productForm">
                <input type="hidden" id="productId" name="id">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" id="productName" name="name" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" id="productCategory" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Fish & Meat">Fish & Meat</option>
                        <option value="Fruits & Vegetables">Fruits & Vegetables</option>
                        <option value="Bakery Items & Cakes">Bakery Items & Cakes</option>
                        <option value="Dairy Products & Protein">Dairy Products & Protein</option>
                        <option value="Household Materials">Household Materials</option>
                        <option value="Processed Foods">Processed Foods</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price (LKR)</label>
                    <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" class="form-control" id="productStock" name="stock" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="text" class="form-control" id="productImage" name="image" placeholder="Images & Logos/products/product.jpg">
                </div>
                <button type="submit" class="action-btn">Save Product</button>
            </form>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Category</h2>
                <span class="close" onclick="closeModal('categoryModal')">&times;</span>
            </div>
            <form id="categoryForm">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="name" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="text" class="form-control" id="categoryImage" name="image" placeholder="Images & Logos/category.png">
                </div>
                <button type="submit" class="action-btn">Save Category</button>
            </form>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Review</h2>
                <span class="close" onclick="closeModal('reviewModal')">&times;</span>
            </div>
            <form id="reviewForm">
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" id="reviewCustomerName" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="reviewUsername" name="customer_username" placeholder="@username">
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <select class="form-control" id="reviewRating" name="rating" required>
                        <option value="">Select Rating</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control" id="reviewComment" name="comment" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Profile Image URL</label>
                    <input type="text" class="form-control" id="reviewProfileImage" name="profile_image" placeholder="Images & Logos/dp (2).png">
                </div>
                <button type="submit" class="action-btn">Save Review</button>
            </form>
        </div>
    </div>

    <script>
        let currentData = {
            products: [],
            orders: [],
            customers: [],
            categories: [],
            reviews: [],
            settings: {}
        };

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardStats();
            loadAllData();
        });

        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }

        // Menu navigation
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show selected section
                const sectionId = this.getAttribute('data-section') + '-section';
                const targetSection = document.getElementById(sectionId);
                if (targetSection) {
                    targetSection.classList.add('active');
                    
                    // Load data for specific sections
                    const section = this.getAttribute('data-section');
                    if (section === 'products' && currentData.products.length === 0) {
                        loadProducts();
                    } else if (section === 'orders' && currentData.orders.length === 0) {
                        loadOrders();
                    } else if (section === 'customers' && currentData.customers.length === 0) {
                        loadCustomers();
                    } else if (section === 'categories' && currentData.categories.length === 0) {
                        loadCategories();
                    } else if (section === 'reviews' && currentData.reviews.length === 0) {
                        loadReviews();
                    } else if (section === 'settings' && Object.keys(currentData.settings).length === 0) {
                        loadSettings();
                    }
                }

                // Update header title
                const headerTitle = document.querySelector('.dashboard-header h1');
                const sectionName = this.querySelector('span').textContent;
                headerTitle.innerHTML = `<i class="${this.querySelector('i').className}"></i>${sectionName}`;
            });
        });

        // Load dashboard statistics
        function loadDashboardStats() {
            fetch('admin_api.php?action=get_stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const stats = data.data;
                        document.getElementById('totalProducts').textContent = stats.total_products || '0';
                        document.getElementById('totalOrders').textContent = stats.total_orders || '0';
                        document.getElementById('totalRevenue').textContent = 'LKR ' + (parseFloat(stats.total_revenue || 0).toLocaleString());
                        document.getElementById('lowStock').textContent = stats.low_stock_count || '0';
                    }
                })
                .catch(error => console.error('Error loading stats:', error));
        }

        // Load all data
        function loadAllData() {
            loadProducts();
            loadOrders();
            loadCustomers();
            loadCategories();
            loadReviews();
            loadSettings();
        }

        // Load products
        function loadProducts() {
            fetch('admin_api.php?action=get_products')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.products = data.data;
                        displayProducts(data.data);
                    }
                })
                .catch(error => console.error('Error loading products:', error));
        }

        function displayProducts(products) {
            const tbody = document.getElementById('productsTableBody');
            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No products found</td></tr>';
                return;
            }

            tbody.innerHTML = products.map(product => `
                <tr>
                    <td>#PR${String(product.id).padStart(3, '0')}</td>
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>LKR ${parseFloat(product.price).toFixed(2)}</td>
                    <td>${product.stock}</td>
                    <td><span class="status-badge ${product.status === 'active' ? 'status-active' : 'status-inactive'}">${product.status}</span></td>
                    <td>
                        <button class="action-btn btn-small" onclick="editProduct(${product.id})">Edit</button>
                        <button class="action-btn btn-small btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        // Load orders
        function loadOrders() {
            fetch('admin_api.php?action=get_orders')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.orders = data.data;
                        displayOrders(data.data);
                    }
                })
                .catch(error => console.error('Error loading orders:', error));
        }

        function displayOrders(orders) {
            const tbody = document.getElementById('ordersTableBody');
            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No orders found</td></tr>';
                return;
            }

            tbody.innerHTML = orders.map(order => `
                <tr>
                    <td>#ORD${String(order.id).padStart(3, '0')}</td>
                    <td>${order.customer_name}</td>
                    <td>${new Date(order.created_at).toLocaleDateString()}</td>
                    <td>${order.item_count || 0}</td>
                    <td>LKR ${parseFloat(order.total_amount).toFixed(2)}</td>
                    <td><span class="status-badge status-${order.status}">${order.status}</span></td>
                    <td>
                        <button class="action-btn btn-small" onclick="viewOrder(${order.id})">View</button>
                        <select onchange="updateOrderStatus(${order.id}, this.value)" style="padding: 3px;">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                            <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select>
                    </td>
                </tr>
            `).join('');
        }

        // Load customers
        function loadCustomers() {
            fetch('admin_api.php?action=get_customers')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.customers = data.data;
                        displayCustomers(data.data);
                    }
                })
                .catch(error => console.error('Error loading customers:', error));
        }

        function displayCustomers(customers) {
            const tbody = document.getElementById('customersTableBody');
            if (customers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No customers found</td></tr>';
                return;
            }

            tbody.innerHTML = customers.map(customer => `
                <tr>
                    <td>${customer.name}</td>
                    <td>${customer.email}</td>
                    <td>${customer.phone || 'N/A'}</td>
                    <td>${customer.total_orders}</td>
                    <td>LKR ${parseFloat(customer.total_spent || 0).toFixed(2)}</td>
                    <td>${new Date(customer.last_order).toLocaleDateString()}</td>
                </tr>
            `).join('');
        }

        // Load categories
        function loadCategories() {
            fetch('admin_api.php?action=get_categories')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.categories = data.data;
                        displayCategories(data.data);
                    }
                })
                .catch(error => console.error('Error loading categories:', error));
        }

        function displayCategories(categories) {
            const tbody = document.getElementById('categoriesTableBody');
            if (categories.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No categories found</td></tr>';
                return;
            }

            tbody.innerHTML = categories.map(category => `
                <tr>
                    <td>${category.name}</td>
                    <td>${category.description || 'N/A'}</td>
                    <td><span class="status-badge ${category.status === 'active' ? 'status-active' : 'status-inactive'}">${category.status}</span></td>
                    <td>${new Date(category.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="action-btn btn-small btn-danger" onclick="deleteCategory(${category.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        // Load reviews
        function loadReviews() {
            fetch('admin_api.php?action=get_reviews')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.reviews = data.data;
                        displayReviews(data.data);
                    }
                })
                .catch(error => console.error('Error loading reviews:', error));
        }

        function displayReviews(reviews) {
            const tbody = document.getElementById('reviewsTableBody');
            if (reviews.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No reviews found</td></tr>';
                return;
            }

            tbody.innerHTML = reviews.map(review => `
                <tr>
                    <td>${review.customer_name}</td>
                    <td>${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${review.comment}</td>
                    <td><span class="status-badge ${review.status === 'active' ? 'status-active' : 'status-inactive'}">${review.status}</span></td>
                    <td>${new Date(review.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="action-btn btn-small" onclick="toggleReviewStatus(${review.id}, '${review.status === 'active' ? 'inactive' : 'active'}')">${review.status === 'active' ? 'Hide' : 'Show'}</button>
                        <button class="action-btn btn-small btn-danger" onclick="deleteReview(${review.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        // Load settings
        function loadSettings() {
            fetch('admin_api.php?action=get_settings')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentData.settings = data.data;
                        displaySettings(data.data);
                    }
                })
                .catch(error => console.error('Error loading settings:', error));
        }

        function displaySettings(settings) {
            Object.keys(settings).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = settings[key] || '';
                }
            });
        }

        // Modal functions
        function openAddProductModal() {
            document.getElementById('productModalTitle').textContent = 'Add Product';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModal').style.display = 'block';
        }

        function openAddCategoryModal() {
            document.getElementById('categoryForm').reset();
            document.getElementById('categoryModal').style.display = 'block';
        }

        function openAddReviewModal() {
            document.getElementById('reviewForm').reset();
            document.getElementById('reviewModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Product functions
        function editProduct(id) {
            const product = currentData.products.find(p => p.id == id);
            if (product) {
                document.getElementById('productModalTitle').textContent = 'Edit Product';
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productStock').value = product.stock;
                document.getElementById('productDescription').value = product.description || '';
                document.getElementById('productImage').value = product.image || '';
                document.getElementById('productModal').style.display = 'block';
            }
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                const formData = new FormData();
                formData.append('action', 'delete_product');
                formData.append('id', id);

                fetch('admin_api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product deleted successfully');
                        loadProducts();
                        loadDashboardStats();
                    } else {
                        alert(data.message || 'Failed to delete product');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product');
                });
            }
        }

        // Order functions
        function updateOrderStatus(id, status) {
            const formData = new FormData();
            formData.append('action', 'update_order_status');
            formData.append('id', id);
            formData.append('status', status);

            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadOrders();
                    loadDashboardStats();
                } else {
                    alert(data.message || 'Failed to update order status');
                    loadOrders(); // Reload to reset the select
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadOrders();
            });
        }

        function viewOrder(id) {
            alert('Order details view - Order ID: ' + id + '\nThis would show detailed order information.');
        }

        // Review functions
        function toggleReviewStatus(id, status) {
            const formData = new FormData();
            formData.append('action', 'update_review_status');
            formData.append('id', id);
            formData.append('status', status);

            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadReviews();
                } else {
                    alert(data.message || 'Failed to update review status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating review status');
            });
        }

        function deleteReview(id) {
            if (confirm('Are you sure you want to delete this review?')) {
                const formData = new FormData();
                formData.append('action', 'delete_review');
                formData.append('id', id);

                fetch('admin_api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Review deleted successfully');
                        loadReviews();
                    } else {
                        alert(data.message || 'Failed to delete review');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting review');
                });
            }
        }

        // Form submissions
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const action = document.getElementById('productId').value ? 'update_product' : 'add_product';
            formData.append('action', action);
            
            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal('productModal');
                    loadProducts();
                    loadDashboardStats();
                } else {
                    alert(data.message || 'Operation failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving product');
            });
        });

        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'add_category');
            
            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal('categoryModal');
                    loadCategories();
                } else {
                    alert(data.message || 'Failed to add category');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding category');
            });
        });

        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'add_review');
            
            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal('reviewModal');
                    loadReviews();
                } else {
                    alert(data.message || 'Failed to add review');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding review');
            });
        });

        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'update_settings');
            
            const settings = {};
            ['site_name', 'site_tagline', 'site_description', 'contact_email', 'contact_phone', 'store_address'].forEach(key => {
                settings[key] = document.getElementById(key).value;
            });
            
            formData.append('settings', JSON.stringify(settings));
            
            fetch('admin_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Settings updated successfully');
                } else {
                    alert(data.message || 'Failed to update settings');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating settings');
            });
        });

        // Logout functionality
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                const formData = new FormData();
                formData.append('action', 'logout');
                
                fetch('auth.php', {
                    method: 'POST',
                    body: formData
                })
                .then(() => {
                    window.location.href = 'index.html';
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = 'index.html';
                });
            }
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['productModal', 'categoryModal', 'reviewModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Auto-refresh dashboard stats every 30 seconds
        setInterval(() => {
            loadDashboardStats();
        }, 30000);
    </script>
</body>
</html>