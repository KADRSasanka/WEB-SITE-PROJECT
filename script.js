let searchForm = document.querySelector('.search-form');
let shoppingCart = document.querySelector('.shopping-cart');
let loginForm = document.querySelector('.login-form');
let navbar = document.querySelector('ul');

let searchBtn = document.querySelector('#search-btn');
let cartBtn = document.querySelector('#cart-btn');
let loginBtn = document.querySelector('#login-btn');
let menuBtn = document.querySelector('#btn');

// Toggle search form
searchBtn.onclick = (e) => {
    searchForm.classList.toggle('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
};

// Toggle cart
cartBtn.onclick = (e) => {
    shoppingCart.classList.toggle('active');
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
};

// Toggle login form
loginBtn.onclick = (e) => {
    loginForm.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
};

// Toggle menu
menuBtn.onclick = (e) => {
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
};

// Remove all active when scrolling
window.onscroll = (e) => {
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
};

let productContainerHTML = document.querySelector('.productContainer');
let productContainers = [];

let boxHTML = document.querySelector('.box');
let carts = [];

let iconCartSpan = document.querySelector('.icon-cart .cart-span')

const addDataToHTML = () => {
  productContainers.innerHTML = '';
  if(productContainers.length > 0) {
      productContainers.forEach(product => {
      let newProduct = document.createElement('div');
      newProduct.classList.add('productCard');
      newProduct.dataset.id = product.id;
      newProduct.innerHTML = `
        <div class="product-image"><img src="${product.image}"></div>
        <h3>${product.name}</h3>
        <p>${product.category}</p>
        <p class="price">LKR ${product.price}</p>
        <button class="buy-now"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Add to Cart</button>
        `;
        productContainerHTML.appendChild(newProduct);
    })
  }
}
productContainerHTML.addEventListener('click', (event) => {
  let positionClick = event.target;
  if(positionClick.classList.contains('buy-now')) {
    let product_id = positionClick.parentElement.dataset.id;
    addToCart(product_id)
  }
})

const addToCart = (product_id) => {
  let positionThisProductInCart = carts.findIndex((value) => value.product_id == product_id);
  if(carts.length <= 0) {
    carts = [{
      product_id: product_id,
      quantity: 1
    }]
  } else if(positionThisProductInCart < 0) {
    carts.push ({
      product_id: product_id,
      quantity: 1
    });
  } else {
    carts[positionThisProductInCart].quantity = carts[positionThisProductInCart].quantity + 1;
  }
  addToCartHTML();
  addCartToMemory();
}
const addCartToMemory = () => {
  localStorage.setItem('cart',JSON.stringify(carts));
}
const addToCartHTML = () => {
  boxHTML.innerHTML = '';
  let totalQuantity = 0;
  let totalPrice = 0;
  if(carts.length > 0) {
    carts.forEach(cart => {
      totalQuantity = totalQuantity + cart.quantity;
      // Find the matching product safely
      //let info = productContainers.find((value) => value.id == cart.product_id);
      //if (!info) return; // skip if product not found
      totalPrice += info.price * cart.quantity; // add to total price
      let newCart = document.createElement('div');
      newCart.classList.add('item');
      newCart.dataset.id = cart.product_id;
      let positionProduct = productContainers.findIndex((value) => value.id == cart.product_id);
      let info = productContainers[positionProduct];
      newCart.innerHTML = `
        <div class="product-image"><img src="${info.image}"></div>
        <div class="name">${info.name}</div>
        <div class="price">LKR ${info.price * cart.quantity}</div>
        <div class="quantity">
            <span class="minus">-</span>
            <span>${cart.quantity}</span>
            <span class="plus">+</span>
        </div>
      `;
    boxHTML.appendChild(newCart);
    })
  }
  iconCartSpan.innerText = totalQuantity;
}
boxHTML.addEventListener('click',(event)=> {
  let positionClick =event.target;
  if(positionClick.classList.contains('minus') || positionClick.classList.contains('plus')) {
    let product_id = positionClick.closest('.item').dataset.id;
    let type = 'minus';
    if(positionClick.classList.contains('plus')) {
      type = 'plus';
    }
    changeQuantity(product_id, type);
  }
})
const changeQuantity = (product_id, type) => {
  let positionItemInCart = carts.findIndex((value) => value.product_id == product_id);
  if(positionItemInCart >= 0) {
    switch (type) {
      case 'plus':
        carts[positionItemInCart].quantity = carts[positionItemInCart].quantity + 1;
        break;

      default:
        let valueChange = carts[positionItemInCart].quantity - 1;
        if(valueChange > 0) {
          carts[positionItemInCart].quantity = valueChange;
        } else {
          carts.splice(positionItemInCart, 1);
        }
        break;
    }
  }
  addCartToMemory();
  addToCartHTML();
}

const initApp = () => {
  //get data from JSON
  fetch("h-products.json")
  .then(response => response.json())
  .then(data => {
    productContainers = data;
    addDataToHTML();

    //get cart from memory
    if(localStorage.getItem('cart')) {
      carts = JSON.parse(localStorage.getItem('cart'));
      addToCartHTML();
    }
  })
}
initApp();

document.getElementById("catogorieslink").addEventListener("click", function(e) {
  e.preventDefault(); // prevent default jump
  document.getElementById("catogories").scrollIntoView({
    behavior: "smooth"
  });
});

document.getElementById("homeLink").addEventListener("click", function(e) {
  e.preventDefault();
  document.getElementById("home").scrollIntoView({
    behavior: "smooth"
  });
});
document.getElementById("aboutLink").addEventListener("click", function(e) {
  e.preventDefault();
  document.getElementById("about").scrollIntoView({
    behavior: "smooth"
  });
});
document.getElementById("productsLink").addEventListener("click", function(e) {
  e.preventDefault();
  document.getElementById("products").scrollIntoView({
    behavior: "smooth"
  });
});
document.getElementById("reviewLink").addEventListener("click", function(e) {
  e.preventDefault();
  document.getElementById("review").scrollIntoView({
    behavior: "smooth"
  });
});

// Login Integration for Xpress Mart Admin Dashboard
// Add this to your existing script.js file

// Admin credentials (in a real application, this would be handled server-side)
const adminCredentials = {
    email: 'admin@xpressmart.lk',
    password: 'admin123'
};

// Enhanced login form handling
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.login-form');
    
    if (loginForm) {
        const emailInput = loginForm.querySelector('input[type="email"]');
        const passwordInput = loginForm.querySelector('input[type="password"]');
        const submitBtn = loginForm.querySelector('.checkout-btn');

        // Add event listener to login form
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });

        // Handle login functionality
        function handleLogin() {
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            // Show loading state
            submitBtn.innerHTML = 'Logging in...';
            submitBtn.disabled = true;

            // Simulate authentication delay
            setTimeout(() => {
                if (email === adminCredentials.email && password === adminCredentials.password) {
                    // Admin login successful
                    localStorage.setItem('adminLoggedIn', 'true');
                    localStorage.setItem('userRole', 'admin');
                    localStorage.setItem('userEmail', email);
                    
                    // Show success message
                    showNotification('Login successful! Redirecting to admin dashboard...', 'success');
                    
                    // Close login form
                    document.getElementById('login-btn').click();
                    
                    // Redirect to admin dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = 'admin-dashboard.html';
                    }, 1500);
                    
                } else if (email && password) {
                    // Regular user login (you can expand this for regular users)
                    localStorage.setItem('userLoggedIn', 'true');
                    localStorage.setItem('userRole', 'customer');
                    localStorage.setItem('userEmail', email);
                    
                    showNotification('Welcome back!', 'success');
                    document.getElementById('login-btn').click(); // Close login form
                    
                } else {
                    // Invalid credentials
                    showNotification('Invalid email or password!', 'error');
                }

                // Reset button
                submitBtn.innerHTML = 'LOG IN';
                submitBtn.disabled = false;
                
                // Clear password field for security
                passwordInput.value = '';
                
            }, 1000);
        }
    }

    // Check if user is already logged in
    checkLoginStatus();
});

// Check login status and update UI accordingly
function checkLoginStatus() {
    const isAdminLoggedIn = localStorage.getItem('adminLoggedIn');
    const isUserLoggedIn = localStorage.getItem('userLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    const loginBtn = document.getElementById('login-btn');
    
    if (isAdminLoggedIn || isUserLoggedIn) {
        // Update login button to show logged in state
        if (loginBtn) {
            loginBtn.style.color = '#27ae60';
            loginBtn.title = `Logged in as: ${userEmail}`;
            
            // Add logout functionality
            loginBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showLogoutMenu();
            });
        }
    }
}

// Show logout menu
function showLogoutMenu() {
    const isAdmin = localStorage.getItem('adminLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    
    let menuContent = `
        <div style="position: fixed; top: 80px; right: 20px; background: white; border-radius: 10px; 
                    box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 20px; z-index: 1000; min-width: 200px;">
            <div style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                <strong style="color: #2c3e50;">Logged in as:</strong><br>
                <span style="color: #27ae60;">${userEmail}</span>
            </div>
    `;
    
    if (isAdmin) {
        menuContent += `
            <button onclick="goToAdminDashboard()" 
                    style="width: 100%; padding: 10px; margin-bottom: 10px; background: #27ae60; 
                           color: white; border: none; border-radius: 5px; cursor: pointer;">
                <i class="fa-solid fa-tachometer-alt"></i> Admin Dashboard
            </button>
        `;
    }
    
    menuContent += `
            <button onclick="logout()" 
                    style="width: 100%; padding: 10px; background: #e74c3c; color: white; 
                           border: none; border-radius: 5px; cursor: pointer;">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </button>
            <div style="position: absolute; top: -10px; right: 20px; width: 0; height: 0; 
                        border-left: 10px solid transparent; border-right: 10px solid transparent; 
                        border-bottom: 10px solid white;"></div>
        </div>
    `;
    
    // Remove existing menu if any
    const existingMenu = document.getElementById('logout-menu');
    if (existingMenu) {
        existingMenu.remove();
    }
    
    // Create and show menu
    const menuDiv = document.createElement('div');
    menuDiv.id = 'logout-menu';
    menuDiv.innerHTML = menuContent;
    document.body.appendChild(menuDiv);
    
    // Close menu when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeMenu(e) {
            if (!menuDiv.contains(e.target) && e.target.id !== 'login-btn') {
                menuDiv.remove();
                document.removeEventListener('click', closeMenu);
            }
        });
    }, 100);
}

// Navigate to admin dashboard
function goToAdminDashboard() {
    window.location.href = 'admin-dashboard.html';
}

// Logout functionality
function logout() {
    localStorage.removeItem('adminLoggedIn');
    localStorage.removeItem('userLoggedIn');
    localStorage.removeItem('userRole');
    localStorage.removeItem('userEmail');
    
    showNotification('Logged out successfully!', 'success');
    
    // Remove logout menu
    const menu = document.getElementById('logout-menu');
    if (menu) menu.remove();
    
    // Reset login button
    const loginBtn = document.getElementById('login-btn');
    if (loginBtn) {
        loginBtn.style.color = '#ffffff';
        loginBtn.title = '';
    }
    
    // Redirect to home if on admin page
    if (window.location.href.includes('admin-dashboard.html')) {
        window.location.href = 'index.html';
    }
}

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        max-width: 300px;
    `;
    
    // Set background color based on type
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        info: '#3498db',
        warning: '#f39c12'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    // Add slide-in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease reverse';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            if (style.parentNode) {
                style.parentNode.removeChild(style);
            }
        }, 300);
    }, 3000);
}

// Add admin access shortcut (Ctrl+Shift+A)
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.key === 'A') {
        e.preventDefault();
        const email = prompt('Enter admin email:');
        const password = prompt('Enter admin password:');
        
        if (email === adminCredentials.email && password === adminCredentials.password) {
            localStorage.setItem('adminLoggedIn', 'true');
            localStorage.setItem('userRole', 'admin');
            localStorage.setItem('userEmail', email);
            window.location.href = 'admin-dashboard.html';
        } else {
            alert('Invalid admin credentials!');
        }
    }
});

// Login Integration for Xpress Mart Admin Dashboard
// Add this to your existing script.js file

// Admin credentials (in a real application, this would be handled server-side)
const adminCredentials = {
    email: 'admin@xpressmart.lk',
    password: 'admin123'
};

// Enhanced login form handling
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.login-form');
    
    if (loginForm) {
        const emailInput = loginForm.querySelector('input[type="email"]');
        const passwordInput = loginForm.querySelector('input[type="password"]');
        const submitBtn = loginForm.querySelector('.checkout-btn');

        // Add event listener to login form
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });

        // Handle login functionality
        function handleLogin() {
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            // Show loading state
            submitBtn.innerHTML = 'Logging in...';
            submitBtn.disabled = true;

            // Simulate authentication delay
            setTimeout(() => {
                if (email === adminCredentials.email && password === adminCredentials.password) {
                    // Admin login successful
                    localStorage.setItem('adminLoggedIn', 'true');
                    localStorage.setItem('userRole', 'admin');
                    localStorage.setItem('userEmail', email);
                    
                    // Show success message
                    showNotification('Login successful! Redirecting to admin dashboard...', 'success');
                    
                    // Close login form
                    document.getElementById('login-btn').click();
                    
                    // Redirect to admin dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = 'admin-dashboard.html';
                    }, 1500);
                    
                } else if (email && password) {
                    // Regular user login (you can expand this for regular users)
                    localStorage.setItem('userLoggedIn', 'true');
                    localStorage.setItem('userRole', 'customer');
                    localStorage.setItem('userEmail', email);
                    
                    showNotification('Welcome back!', 'success');
                    document.getElementById('login-btn').click(); // Close login form
                    
                } else {
                    // Invalid credentials
                    showNotification('Invalid email or password!', 'error');
                }

                // Reset button
                submitBtn.innerHTML = 'LOG IN';
                submitBtn.disabled = false;
                
                // Clear password field for security
                passwordInput.value = '';
                
            }, 1000);
        }
    }

    // Check if user is already logged in
    checkLoginStatus();
});

// Check login status and update UI accordingly
function checkLoginStatus() {
    const isAdminLoggedIn = localStorage.getItem('adminLoggedIn');
    const isUserLoggedIn = localStorage.getItem('userLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    const loginBtn = document.getElementById('login-btn');
    
    if (isAdminLoggedIn || isUserLoggedIn) {
        // Update login button to show logged in state
        if (loginBtn) {
            loginBtn.style.color = '#27ae60';
            loginBtn.title = `Logged in as: ${userEmail}`;
            
            // Add logout functionality
            loginBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showLogoutMenu();
            });
        }
    }
}

// Show logout menu
function showLogoutMenu() {
    const isAdmin = localStorage.getItem('adminLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    
    let menuContent = `
        <div style="position: fixed; top: 80px; right: 20px; background: white; border-radius: 10px; 
                    box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 20px; z-index: 1000; min-width: 200px;">
            <div style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                <strong style="color: #2c3e50;">Logged in as:</strong><br>
                <span style="color: #27ae60;">${userEmail}</span>
            </div>
    `;
    
    if (isAdmin) {
        menuContent += `
            <button onclick="goToAdminDashboard()" 
                    style="width: 100%; padding: 10px; margin-bottom: 10px; background: #27ae60; 
                           color: white; border: none; border-radius: 5px; cursor: pointer;">
                <i class="fa-solid fa-tachometer-alt"></i> Admin Dashboard
            </button>
        `;
    }
    
    menuContent += `
            <button onclick="logout()" 
                    style="width: 100%; padding: 10px; background: #e74c3c; color: white; 
                           border: none; border-radius: 5px; cursor: pointer;">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </button>
            <div style="position: absolute; top: -10px; right: 20px; width: 0; height: 0; 
                        border-left: 10px solid transparent; border-right: 10px solid transparent; 
                        border-bottom: 10px solid white;"></div>
        </div>
    `;
    
    // Remove existing menu if any
    const existingMenu = document.getElementById('logout-menu');
    if (existingMenu) {
        existingMenu.remove();
    }
    
    // Create and show menu
    const menuDiv = document.createElement('div');
    menuDiv.id = 'logout-menu';
    menuDiv.innerHTML = menuContent;
    document.body.appendChild(menuDiv);
    
    // Close menu when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeMenu(e) {
            if (!menuDiv.contains(e.target) && e.target.id !== 'login-btn') {
                menuDiv.remove();
                document.removeEventListener('click', closeMenu);
            }
        });
    }, 100);
}

// Navigate to admin dashboard
function goToAdminDashboard() {
    window.location.href = 'admin-dashboard.html';
}

// Logout functionality
function logout() {
    localStorage.removeItem('adminLoggedIn');
    localStorage.removeItem('userLoggedIn');
    localStorage.removeItem('userRole');
    localStorage.removeItem('userEmail');
    
    showNotification('Logged out successfully!', 'success');
    
    // Remove logout menu
    const menu = document.getElementById('logout-menu');
    if (menu) menu.remove();
    
    // Reset login button
    const loginBtn = document.getElementById('login-btn');
    if (loginBtn) {
        loginBtn.style.color = '#ffffff';
        loginBtn.title = '';
    }
    
    // Redirect to home if on admin page
    if (window.location.href.includes('admin-dashboard.html')) {
        window.location.href = 'index.html';
    }
}

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        max-width: 300px;
    `;
    
    // Set background color based on type
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        info: '#3498db',
        warning: '#f39c12'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    // Add slide-in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease reverse';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            if (style.parentNode) {
                style.parentNode.removeChild(style);
            }
        }, 300);
    }, 3000);
}

// Add admin access shortcut (Ctrl+Shift+A)
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.key === 'A') {
        e.preventDefault();
        const email = prompt('Enter admin email:');
        const password = prompt('Enter admin password:');
        
        if (email === adminCredentials.email && password === adminCredentials.password) {
            localStorage.setItem('adminLoggedIn', 'true');
            localStorage.setItem('userRole', 'admin');
            localStorage.setItem('userEmail', email);
            window.location.href = 'admin-dashboard.html';
        } else {
            alert('Invalid admin credentials!');
        }
    }
});