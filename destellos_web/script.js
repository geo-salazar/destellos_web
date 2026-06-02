let cart = JSON.parse(localStorage.getItem("destellosCart")) || [];

function saveCart() {
    localStorage.setItem("destellosCart", JSON.stringify(cart));
}

function formatMoney(value) {
    return "₡" + value.toLocaleString("es-CR");
}

function saludar(){
    alert("holka Geo")

}

function addToCart(name, price, image) {

    const existingProduct = cart.find(item => item.name === name);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
    }

    saveCart();
    updateCart();
    openCart();
}

function updateCart() {
    const cartItems = document.getElementById("cart-items");
    const cartCount = document.getElementById("cart-count");
    const cartTotal = document.getElementById("cart-total");
    const checkoutWhatsapp = document.getElementById("checkout-whatsapp");

    if (!cartItems || !cartCount || !cartTotal || !checkoutWhatsapp) {
        return;
    }

    cartItems.innerHTML = "";

    let total = 0;
    let count = 0;

    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="empty-cart">Tu carrito está vacío.</p>';
    }

    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        count += item.quantity;

        const itemHTML = document.createElement("article");
        itemHTML.classList.add("cart-item");

        itemHTML.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div>
                <h4>${item.name}</h4>
                <p>${formatMoney(item.price)}</p>
                <div class="cart-controls">
                    <button onclick="decreaseQuantity(${index})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="increaseQuantity(${index})">+</button>
                    <button class="remove-item" onclick="removeItem(${index})">Eliminar</button>
                </div>
            </div>
        `;

        cartItems.appendChild(itemHTML);
    });

    cartCount.textContent = count;
    cartTotal.textContent = formatMoney(total);

    const message = createWhatsappMessage(total);
    checkoutWhatsapp.href = "https://wa.me/50688888888?text=" + encodeURIComponent(message);
}

function createWhatsappMessage(total) {
    if (cart.length === 0) {
        return "Hola Destellos, quiero información sobre sus joyas.";
    }

    let message = "Hola Destellos, quiero comprar estos productos:%0A%0A";

    cart.forEach(item => {
        message += `- ${item.name} x${item.quantity} = ${formatMoney(item.price * item.quantity)}%0A`;
    });

    message += `%0ATotal: ${formatMoney(total)}`;
    return message;
}

function increaseQuantity(index) {
    cart[index].quantity += 1;
    saveCart();
    updateCart();
}

function decreaseQuantity(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity -= 1;
    } else {
        cart.splice(index, 1);
    }

    saveCart();
    updateCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    updateCart();
}

function clearCart() {
    cart = [];
    saveCart();
    updateCart();
}

function openCart() {
    document.getElementById("cart-panel").classList.add("active");
    document.getElementById("cart-overlay").classList.add("active");
}

function toggleCart() {
    document.getElementById("cart-panel").classList.toggle("active");
    document.getElementById("cart-overlay").classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", updateCart);
