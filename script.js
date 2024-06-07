const cartButton = document.querySelector('.cart-button');
const cartBadge = document.querySelector('.cart-badge');
const modal = document.querySelector('.modal');
const modalClose = document.querySelector('.close');
const buyButton = document.querySelector('.buy-btn');
const cartItemsList = document.querySelector('.cart-items');
const cartTotal = document.querySelector('.cart-total');
const itemsGrid = document.querySelector('.items-grid');
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');

let items = [
    {
        id: 1,
        name: 'Apple',
        price: 0.99,
    },
    {
        id: 2,
        name: 'Banana',
        price: 10,
    },
    {
        id: 3,
        name: 'Orange',
        price: 7.49,
    },
    {
        id: 4,
        name: 'Strawberry',
        price: 2.99,
    },
    {
        id: 5,
        name: 'Lemon',
        price: 4.79,
    },
    {
        id: 6,
        name: 'Pears',
        price: 2.29,
    },
    {
        id: 7,
        name: 'Peaches',
        price: 4.35,
    },
    {
        id: 8,
        name: 'Grapes',
        price: 5,
    },
    {
        id: 9,
        name: 'Watermelon',
        price: 13.33,
    },
    {
        id: 10,
        name: 'Kiwi',
        price: 3.33,
    },
    {
        id: 11,
        name: 'Coconut',
        price: 5.99,
    },
];

let cart = [];


function fillItemsGrid(itemsToDisplay) {
    clearItemsGrid();
    loadImagesForItems(itemsToDisplay);
    for (const item of itemsToDisplay) {
        let itemElement = document.createElement('div');
        itemElement.classList.add('item');
        itemElement.innerHTML = `
            <img src="${item.imagePath}" alt="${item.name}">
            <h2>${item.name}</h2>
            <p>$${item.price}</p>
            <button class="add-to-cart-btn" data-id="${item.id}">Add to cart</button>
        `;
        itemsGrid.appendChild(itemElement);
    }

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', addToCart);
    });
}


function loadImagesForItems(items) {
    items.forEach(item => {
        let imageName = item.name.toLowerCase() + '.png';
        let imagePath = 'images/' + imageName;
        item.imagePath = imagePath;
    });
}

function addToCart(event) {
    const itemId = parseInt(event.target.dataset.id);
    const item = items.find(item => item.id === itemId);

    const cartItem = cart.find(item => item.id === itemId);
    if (cartItem) {
        cartItem.quantity += 1;
    } else {
        cart.push({ ...item, quantity: 1 });
    }

    updateCartBadge();
    updateCartModal();
}

function updateCartBadge() {
    cartBadge.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
}

function updateCartModal() {
    cartItemsList.innerHTML = '';
    let total = 0;
    cart.forEach(item => {
        total += item.price * item.quantity;
        const li = document.createElement('li');
        li.innerHTML = `
            ${item.name} - $${item.price} x ${item.quantity}
            <button class="remove-from-cart-btn" data-id="${item.id}">X</button>
        `;
        cartItemsList.appendChild(li);
    });

    cartTotal.textContent = `Total: $${total.toFixed(2)}`;

    document.querySelectorAll('.remove-from-cart-btn').forEach(button => {
        button.addEventListener('click', removeFromCart);
    });
}

function removeFromCart(event) {
    const itemId = parseInt(event.target.dataset.id);
    const cartItemIndex = cart.findIndex(item => item.id === itemId);
    
    if (cartItemIndex > -1) {
        cart[cartItemIndex].quantity -= 1;
        if (cart[cartItemIndex].quantity === 0) {
            cart.splice(cartItemIndex, 1);
        }
    }

    updateCartBadge();
    updateCartModal();
}

// Adding the .show-modal class to an element will make it visible
// because it has the CSS property display: block; (which overrides display: none;)
// See the CSS file for more details.
function toggleModal() {
  modal.classList.toggle('show-modal');
}

function handlePurchase() {
    if (cart.length === 0) {
        alert("Your cart is empty. Add items to the cart before buying.");
    } else {
        const totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
        alert(`You have successfully buyed ${totalItems} item(s)!`);
        cart = [];
        updateCartBadge();
        updateCartModal();
        toggleModal();
    }
}

function handleSearch() {
    const searchText = searchInput.value.toLowerCase();
    const filteredItems = items.filter(item => item.name.toLowerCase() === searchText);
    fillItemsGrid(filteredItems.length > 0 ? filteredItems : items);
}

function handleSort() {
    const sortValue = sortSelect.value;
    let sortedItems = [...items];

    switch (sortValue) {
        case 'name-asc':
            sortedItems.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'name-desc':
            sortedItems.sort((a, b) => b.name.localeCompare(a.name));
            break;
        case 'price-asc':
            sortedItems.sort((a, b) => a.price - b.price);
            break;
        case 'price-desc':
            sortedItems.sort((a, b) => b.price - a.price);
            break;
    }

    fillItemsGrid(sortedItems);
}

function clearItemsGrid() {
    itemsGrid.innerHTML = '';
}

// Call fillItemsGrid function when page loads
fillItemsGrid(items);

// Example of DOM methods for adding event handling
cartButton.addEventListener('click', toggleModal);
modalClose.addEventListener('click', toggleModal);
buyButton.addEventListener('click', handlePurchase);
searchInput.addEventListener('input', handleSearch);
sortSelect.addEventListener('change', handleSort);
