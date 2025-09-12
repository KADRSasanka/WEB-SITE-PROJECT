let searchForm = document.querySelector('.search-form');
let searchBtn = document.querySelector('#search-btn');
    // Toggle search form when clicking the search icon
searchBtn.onclick = (e) => {
    searchForm.classList.toggle('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
};

let shoppingCart = document.querySelector('.shopping-cart');
let cartBtn = document.querySelector('#cart-btn');
    // Toggle cart form when clicking the cart icon
cartBtn.onclick = (e) => {
    shoppingCart.classList.toggle('active');
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
};

let loginForm = document.querySelector('.login-form');
let loginBtn = document.querySelector('#login-btn');
    // Toggle login form when clicking the cart icon
loginBtn.onclick = (e) => {
    loginForm.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
};

let navbar = document.querySelector('ul');
let menuBtn = document.querySelector('#btn');
    // Toggle login form when clicking the cart icon
menuBtn.onclick = (e) => {
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
};

window.onscroll = () => {
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
}
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


