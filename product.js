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


let productSections = document.querySelectorAll('.productContainer'); // all product containers
let productData = []; // products from JSON
let carts = [];

let boxHTML = document.querySelector('.box');
let iconCartSpan = document.querySelector('.icon-cart .cart-span');

// Render products into correct section
const addDataToHTML = () => {
  productSections.forEach(section => section.innerHTML = ''); // clear all containers

  if (productData.length > 0) {
    productData.forEach(product => {
      let newProduct = document.createElement('div');
      newProduct.classList.add('productCard');
      newProduct.dataset.id = product.id;
      newProduct.innerHTML = `
        <div class="product-image"><img src="${product.image}"></div>
        <h3>${product.name}</h3>
        <p class="price">LKR ${product.price}</p>
        <button class="buy-now"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Add to Cart</button>
      `;

      // Find target container by section id
      let targetSection = document.querySelector(`#${product.section} .productContainer`);
      if (targetSection) targetSection.appendChild(newProduct);
    });
  }
};

// Event delegation for Add to Cart
document.body.addEventListener('click', (event) => {
  if (event.target.classList.contains('buy-now')) {
    let product_id = event.target.closest('.productCard').dataset.id;
    addToCart(product_id);
  }
});

// Add product to cart
const addToCart = (product_id) => {
  let positionThisProductInCart = carts.findIndex((value) => value.product_id == product_id);
  if (positionThisProductInCart < 0) {
    carts.push({ product_id, quantity: 1 });
  } else {
    carts[positionThisProductInCart].quantity++;
  }
  addToCartHTML();
  addCartToMemory();
};

// Save cart to localStorage
const addCartToMemory = () => {
  localStorage.setItem('cart', JSON.stringify(carts));
};

// Update cart display
const addToCartHTML = () => {
  boxHTML.innerHTML = '';
  let totalQuantity = 0;

  carts.forEach(cart => {
    totalQuantity += cart.quantity;
    let product = productData.find(p => p.id == cart.product_id);
    if (!product) return;

    let newCart = document.createElement('div');
    newCart.classList.add('item');
    newCart.dataset.id = cart.product_id;
    newCart.innerHTML = `
      <div class="product-image"><img src="${product.image}"></div>
      <div class="name">${product.name}</div>
      <div class="price">LKR ${product.price * cart.quantity}</div>
      <div class="quantity">
        <span class="minus">-</span>
        <span>${cart.quantity}</span>
        <span class="plus">+</span>
      </div>
    `;
    boxHTML.appendChild(newCart);
  });

  iconCartSpan.innerText = totalQuantity;
};

// Handle + and - in cart
boxHTML.addEventListener('click', (event) => {
  if (event.target.classList.contains('minus') || event.target.classList.contains('plus')) {
    let product_id = event.target.closest('.item').dataset.id;
    let type = event.target.classList.contains('plus') ? 'plus' : 'minus';
    changeQuantity(product_id, type);
  }
});

const changeQuantity = (product_id, type) => {
  let positionItemInCart = carts.findIndex((value) => value.product_id == product_id);
  if (positionItemInCart >= 0) {
    if (type === 'plus') {
      carts[positionItemInCart].quantity++;
    } else {
      carts[positionItemInCart].quantity--;
      if (carts[positionItemInCart].quantity <= 0) {
        carts.splice(positionItemInCart, 1);
      }
    }
  }
  addCartToMemory();
  addToCartHTML();
};

// Initialize app
const initApp = () => {
  fetch("product.json")
    .then(response => response.json())
    .then(data => {
      productData = data;
      addDataToHTML();

      if (localStorage.getItem('cart')) {
        carts = JSON.parse(localStorage.getItem('cart'));
        addToCartHTML();
      }
    });
};
initApp();
