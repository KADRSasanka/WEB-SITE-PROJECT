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

let listProductHTML = document.querySelector('.listProduct');
let listProducts = [];

const addDataToHTML = () => {
  listProductHTML.innerHTML = '';
}

const initApp = () => {
  //get data from JSON
  fetch('h-products.json')
  .then(response => response.json())
  .then(data => {
    listProducts = data;
    addDataToHTML();
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