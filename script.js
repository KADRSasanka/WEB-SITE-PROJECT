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
      let positionProduct = productContainers.findIndex((value) => value.id == cart.product_id);
      let info = productContainers[positionProduct];
      //if (!info) return; // skip if product not found
      totalPrice += info.price * cart.quantity; // add to total price
      let newCart = document.createElement('div');
      newCart.classList.add('item');
      newCart.dataset.id = cart.product_id;
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