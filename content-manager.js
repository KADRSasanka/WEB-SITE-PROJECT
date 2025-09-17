// Dynamic Content Management System for Xpress Mart
// This file manages website content that can be edited through the admin dashboard

// Website Content Storage (in a real app, this would be in a database)
let websiteContent = {
    // Home Page Content
    home: {
        title: "Xpress Mart",
        subtitle: "WHERE FRESHNESS MEETS VALUES",
        description: "We believe in bringing you the freshest ingredients and quality products. Explore our wide selection of farm-fresh fruits and vegetables, premium meats, and artisanal goods, all hand-picked for you. Experience the difference of quality, from our store to your table",
        heroImage: "Images & Logos/1234-Photoroom.png",
        offerText: "25% off Offer"
    },
    
    // Products Data
    products: [
        {
            id: "PR001",
            name: "Hellman's Real Mayonnaise",
            category: "Household Materials",
            price: 499.00,
            image: "Images & Logos/products/pr1.png",
            stock: 45,
            status: "active",
            description: "Premium quality mayonnaise for your kitchen needs"
        },
        {
            id: "PR002",
            name: "Fresh Red Apples",
            category: "Fruits & Vegetables",
            price: 350.00,
            image: "Images & Logos/products/pr2.png",
            stock: 120,
            status: "active",
            description: "Fresh, crispy red apples from local orchards"
        },
        {
            id: "PR003",
            name: "Premium Chicken Breast",
            category: "Fish & Meat",
            price: 850.00,
            image: "Images & Logos/products/pr3.png",
            stock: 0,
            status: "out_of_stock",
            description: "High-quality chicken breast, perfect for healthy meals"
        },
        {
            id: "PR004",
            name: "Whole Wheat Bread",
            category: "Bakery Items & Cakes",
            price: 180.00,
            image: "Images & Logos/products/pr4.png",
            stock: 85,
            status: "active",
            description: "Freshly baked whole wheat bread"
        },
        {
            id: "PR005",
            name: "Fresh Milk 1L",
            category: "Dairy Products & Protein",
            price: 220.00,
            image: "Images & Logos/products/pr5.png",
            stock: 60,
            status: "active",
            description: "Pure, fresh milk from local dairy farms"
        }
    ],

    // Categories Data
    categories: [
        { id: "cat1", name: "Fish & Meat", image: "Images & Logos/s1.png", active: true },
        { id: "cat2", name: "Fruits & Vegetables", image: "Images & Logos/s2.png", active: true },
        { id: "cat3", name: "Bakery Items & Cakes", image: "Images & Logos/s3.png", active: true },
        { id: "cat4", name: "Dairy Products & Protein", image: "Images & Logos/s4.png", active: true },
        { id: "cat5", name: "Household Materials", image: "Images & Logos/s5.png", active: true },
        { id: "cat6", name: "Processed Foods", image: "Images & Logos/s6.png", active: true }
    ],

    // Reviews Data
    reviews: [
        {
            id: "rev1",
            name: "Nisanasala Niroshani",
            username: "@niroshanidmn",
            rating: 4.5,
            comment: "Excellent service and fresh products! I've been shopping here for months and the quality is consistently great. The delivery is always on time.",
            image: "Images & Logos/dp (2).png",
            approved: true
        },
        {
            id: "rev2",
            name: "Aseka Dissanayaka", 
            username: "@dissanayakadman",
            rating: 5,
            comment: "Best supermarket in the area! Fresh vegetables, competitive prices, and excellent customer service. Highly recommended!",
            image: "Images & Logos/dp (2).png",
            approved: true
        },
        {
            id: "rev3",
            name: "Manushi Athukorala",
            username: "@athukorlamp",
            rating: 4,
            comment: "Good variety of products and reasonable prices. The online ordering system works smoothly. Will definitely shop again!",
            image: "Images & Logos/dp (2).png",
            approved: true
        },
        {
            id: "rev4",
            name: "Geesith Kariyawasam",
            username: "@geesithkariyawasm",
            rating: 3.5,
            comment: "Decent selection of items. Some products could be fresher, but overall a good shopping experience.",
            image: "Images & Logos/dp (2).png",
            approved: true
        }
    ],

    // Website Settings
    settings: {
        storeName: "Xpress Mart",
        storeEmail: "info@xpressmart.lk",
        storePhone: "+94 77 123 4567",
        storeAddress: "123 Main Street, Colombo, Sri Lanka",
        currency: "LKR",
        taxRate: 0.15,
        deliveryFee: 200.00,
        minOrderForFreeDelivery: 2000.00
    }
};

// Load content from localStorage on page load
function loadContentFromStorage() {
    const savedContent = localStorage.getItem('websiteContent');
    if (savedContent) {
        websiteContent = JSON.parse(savedContent);
    }
}

// Save content to localStorage
function saveContentToStorage() {
    localStorage.setItem('websiteContent', JSON.stringify(websiteContent));
}

// Initialize content management
document.addEventListener('DOMContentLoaded', function() {
    loadContentFromStorage();
    updateWebsiteContent();
});

// Update website content dynamically
function updateWebsiteContent() {
    // Update home page content
    updateHomeContent();
    // Update products
    updateProductsDisplay();
    // Update categories
    updateCategoriesDisplay();
    // Update reviews
    updateReviewsDisplay();
}

// Update home page content
function updateHomeContent() {
    const homeContent = websiteContent.home;
    
    // Update title
    const titleElement = document.querySelector('.home-content-title');
    if (titleElement) titleElement.textContent = homeContent.title;
    
    // Update subtitle
    const subtitleElement = document.querySelector('.home-content-subtitle');
    if (subtitleElement) subtitleElement.textContent = homeContent.subtitle;
    
    // Update description
    const descriptionElement = document.querySelector('.content-para');
    if (descriptionElement) descriptionElement.innerHTML = homeContent.description.replace(/\n/g, '<br>');
    
    // Update hero image
    const heroImage = document.querySelector('.home-image');
    if (heroImage) heroImage.src = homeContent.heroImage;
    
    // Update offer button text
    const offerButton = document.querySelector('.button1');
    if (offerButton) offerButton.textContent = homeContent.offerText;
}

// Update products display
function updateProductsDisplay() {
    const productContainer = document.querySelector('.productContainer');
    if (!productContainer) return;
    
    productContainer.innerHTML = '';
    
    // Show only active products, limit to 8 for display
    const activeProducts = websiteContent.products
        .filter(product => product.status === 'active')
        .slice(0, 8);
    
    activeProducts.forEach(product => {
        const productCard = createProductCard(product);
        productContainer.appendChild(productCard);
    });
}

// Create product card element
function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'productCard';
    card.innerHTML = `
        <div class="product-image">
            <img src="${product.image}" alt="${product.name}" onerror="this.src='Images & Logos/placeholder.png'">
        </div>
        <h3>${product.name}</h3>
        <p>${product.category}</p>
        <p class="price">LKR ${product.price.toFixed(2)}</p>
        <button class="buy-now" onclick="addToCart('${product.id}')">
            <i class="fa-solid fa-cart-shopping"></i>&nbsp;Add to Cart
        </button>
    `;
    return card;
}

// Update categories display
function updateCategoriesDisplay() {
    const categoriesContainer = document.querySelector('.box-container');
    if (!categoriesContainer) return;
    
    categoriesContainer.innerHTML = '';
    
    websiteContent.categories
        .filter(category => category.active)
        .forEach(category => {
            const categoryBox = document.createElement('div');
            categoryBox.className = 'box';
            categoryBox.innerHTML = `
                <img src="${category.image}" alt="${category.name}">
                <h3>${category.name}</h3>
            `;
            categoriesContainer.appendChild(categoryBox);
        });
}

// Update reviews display
function updateReviewsDisplay() {
    const reviewContainer = document.querySelector('.review-box-container');
    if (!reviewContainer) return;
    
    reviewContainer.innerHTML = '';
    
    websiteContent.reviews
        .filter(review => review.approved)
        .forEach(review => {
            const reviewBox = createReviewBox(review);
            reviewContainer.appendChild(reviewBox);
        });
}

// Create review box element
function createReviewBox(review) {
    const reviewBox = document.createElement('div');
    reviewBox.className = 'review-box';
    
    const fullStars = Math.floor(review.rating);
    const hasHalfStar = review.rating % 1 !== 0;
    const emptyStars = 5 - Math.ceil(review.rating);
    
    let starsHTML = '';
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<i class="fa-solid fa-star"></i>';
    }
    if (hasHalfStar) {
        starsHTML += '<i class="fa-solid fa-star-half-stroke"></i>';
    }
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<i class="fa-regular fa-star"></i>';
    }
    
    reviewBox.innerHTML = `
        <div class="box-top">
            <div class="profile">
                <div class="profile-img">
                    <img src="${review.image}" alt="profile pic">
                </div>
                <div class="name-user">
                    <strong>${review.name}</strong>
                    <span>${review.username}</span>
                </div>
            </div>
            <div class="review-comment">
                ${starsHTML}
            </div>
        </div>
        <div class="client-comment">
            <p>${review.comment}</p>
        </div>
    `;
    return reviewBox;
}

// Content Management Functions (for admin dashboard)
const ContentManager = {
    
    // Home Content Management
    updateHomeContent: function(newContent) {
        websiteContent.home = { ...websiteContent.home, ...newContent };
        saveContentToStorage();
        updateHomeContent();
        return { success: true, message: 'Home content updated successfully' };
    },

    // Product Management
    addProduct: function(product) {
        const newProduct = {
            id: 'PR' + String(Date.now()).slice(-6),
            ...product,
            status: 'active'
        };
        websiteContent.products.push(newProduct);
        saveContentToStorage();
        updateProductsDisplay();
        return { success: true, message: 'Product added successfully', product: newProduct };
    },

    updateProduct: function(productId, updates) {
        const productIndex = websiteContent.products.findIndex(p => p.id === productId);
        if (productIndex === -1) {
            return { success: false, message: 'Product not found' };
        }
        
        websiteContent.products[productIndex] = { ...websiteContent.products[productIndex], ...updates };
        saveContentToStorage();
        updateProductsDisplay();
        return { success: true, message: 'Product updated successfully' };
    },

    deleteProduct: function(productId) {
        const productIndex = websiteContent.products.findIndex(p => p.id === productId);
        if (productIndex === -1) {
            return { success: false, message: 'Product not found' };
        }
        
        websiteContent.products.splice(productIndex, 1);
        saveContentToStorage();
        updateProductsDisplay();
        return { success: true, message: 'Product deleted successfully' };
    },

    getProducts: function() {
        return websiteContent.products;
    },

    // Category Management
    addCategory: function(category) {
        const newCategory = {
            id: 'cat' + Date.now(),
            ...category,
            active: true
        };
        websiteContent.categories.push(newCategory);
        saveContentToStorage();
        updateCategoriesDisplay();
        return { success: true, message: 'Category added successfully' };
    },

    updateCategory: function(categoryId, updates) {
        const categoryIndex = websiteContent.categories.findIndex(c => c.id === categoryId);
        if (categoryIndex === -1) {
            return { success: false, message: 'Category not found' };
        }
        
        websiteContent.categories[categoryIndex] = { ...websiteContent.categories[categoryIndex], ...updates };
        saveContentToStorage();
        updateCategoriesDisplay();
        return { success: true, message: 'Category updated successfully' };
    },

    getCategories: function() {
        return websiteContent.categories;
    },

    // Review Management
    addReview: function(review) {
        const newReview = {
            id: 'rev' + Date.now(),
            ...review,
            approved: false // Reviews need approval
        };
        websiteContent.reviews.push(newReview);
        saveContentToStorage();
        return { success: true, message: 'Review submitted for approval' };
    },

    approveReview: function(reviewId) {
        const reviewIndex = websiteContent.reviews.findIndex(r => r.id === reviewId);
        if (reviewIndex === -1) {
            return { success: false, message: 'Review not found' };
        }
        
        websiteContent.reviews[reviewIndex].approved = true;
        saveContentToStorage();
        updateReviewsDisplay();
        return { success: true, message: 'Review approved successfully' };
    },

    deleteReview: function(reviewId) {
        const reviewIndex = websiteContent.reviews.findIndex(r => r.id === reviewId);
        if (reviewIndex === -1) {
            return { success: false, message: 'Review not found' };
        }
        
        websiteContent.reviews.splice(reviewIndex, 1);
        saveContentToStorage();
        updateReviewsDisplay();
        return { success: true, message: 'Review deleted successfully' };
    },

    getReviews: function() {
        return websiteContent.reviews;
    },

    // Settings Management
    updateSettings: function(newSettings) {
        websiteContent.settings = { ...websiteContent.settings, ...newSettings };
        saveContentToStorage();
        return { success: true, message: 'Settings updated successfully' };
    },

    getSettings: function() {
        return websiteContent.settings;
    },

    // Bulk operations
    exportContent: function() {
        return JSON.stringify(websiteContent, null, 2);
    },

    importContent: function(jsonContent) {
        try {
            const importedContent = JSON.parse(jsonContent);
            websiteContent = importedContent;
            saveContentToStorage();
            updateWebsiteContent();
            return { success: true, message: 'Content imported successfully' };
        } catch (error) {
            return { success: false, message: 'Invalid JSON format' };
        }
    },

    // Get dashboard statistics
    getStats: function() {
        return {
            totalProducts: websiteContent.products.length,
            activeProducts: websiteContent.products.filter(p => p.status === 'active').length,
            outOfStockProducts: websiteContent.products.filter(p => p.status === 'out_of_stock').length,
            totalCategories: websiteContent.categories.filter(c => c.active).length,
            totalReviews: websiteContent.reviews.filter(r => r.approved).length,
            pendingReviews: websiteContent.reviews.filter(r => !r.approved).length,
            averageRating: this.calculateAverageRating()
        };
    },

    calculateAverageRating: function() {
        const approvedReviews = websiteContent.reviews.filter(r => r.approved);
        if (approvedReviews.length === 0) return 0;
        
        const totalRating = approvedReviews.reduce((sum, review) => sum + review.rating, 0);
        return (totalRating / approvedReviews.length).toFixed(1);
    }
};

// Make ContentManager available globally for admin dashboard
window.ContentManager = ContentManager;

// Shopping cart functionality (basic implementation)
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(productId) {
    const product = websiteContent.products.find(p => p.id === productId);
    if (!product || product.status !== 'active') {
        alert('Product not available');
        return;
    }

    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
    showNotification(`${product.name} added to cart!`, 'success');
}

function updateCartDisplay() {
    const cartSpan = document.querySelector('.cart-span');
    const cartTotal = cart.reduce((total, item) => total + item.quantity, 0);
    if (cartSpan) cartSpan.textContent = cartTotal;

    const cartContainer = document.querySelector('.shopping-cart .box .item');
    const totalElement = document.querySelector('.shopping-cart .total');
    
    if (cartContainer) {
        cartContainer.innerHTML = '';
        let totalPrice = 0;

        cart.forEach(item => {
            totalPrice += item.price * item.quantity;
            
            const cartItem = document.createElement('div');
            cartItem.innerHTML = `
                <div class="product-image"><img src="${item.image}"></div>
                <div class="name">${item.name}</div>
                <div class="price">LKR ${item.price.toFixed(2)}</div>
                <div class="quantity">
                    <span class="minus" onclick="updateCartQuantity('${item.id}', -1)">-</span>
                    <span>${item.quantity}</span>
                    <span class="plus" onclick="updateCartQuantity('${item.id}', 1)">+</span>
                </div>
            `;
            cartContainer.appendChild(cartItem);
        });

        if (totalElement) {
            totalElement.textContent = `TOTAL: LKR ${totalPrice.toFixed(2)}`;
        }
    }
}

function updateCartQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            cart = cart.filter(cartItem => cartItem.id !== productId);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartDisplay();
    }
}

// Initialize cart display on page load
document.addEventListener('DOMContentLoaded', updateCartDisplay);