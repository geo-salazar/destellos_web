// Inicialización del carrito: recupera datos guardados o inicia un arreglo vacío
let cart = JSON.parse(localStorage.getItem("destellosCart")) || [];

// Guarda el estado actual del carrito en el navegador
function saveCart() {
    localStorage.setItem("destellosCart", JSON.stringify(cart));
}

// Formatea números a moneda local (Colones costarricenses)
function formatMoney(value) {
    return "₡" + value.toLocaleString("es-CR");
}

// Añade un producto al carrito o incrementa su cantidad si ya existe
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

// Refresca la interfaz visual del carrito (conteo, lista de items y total)
function updateCart() {
    const cartItems = document.getElementById("cart-items");
    const cartCount = document.getElementById("cart-count");
    const cartTotal = document.getElementById("cart-total");
    const checkoutWhatsapp = document.getElementById("checkout-whatsapp");

    if (!cartCount) {
        return;
    }

    let total = 0;
    let count = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
        count += item.quantity;
    });

    cartCount.textContent = count;

    if (cartTotal) {
        cartTotal.textContent = formatMoney(total);
    }

    if (cartItems) {
        cartItems.innerHTML = "";

        if (cart.length === 0) {
            cartItems.innerHTML = '<p class="empty-cart">Tu carrito está vacío.</p>';
        }

        cart.forEach((item, index) => {
            const itemHTML = document.createElement("article");
            itemHTML.classList.add("cart-item");

            itemHTML.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div>
                    <h4>${item.name}</h4>
                    <p>${formatMoney(item.price)}</p>

                    <div class="cart-controls">
                        <button type="button" onclick="decreaseQuantity(${index})">-</button>
                        <span>${item.quantity}</span>
                        <button type="button" onclick="increaseQuantity(${index})">+</button>
                        <button type="button" class="remove-item" onclick="removeItem(${index})">
                            Eliminar
                        </button>
                    </div>
                </div>
            `;

            cartItems.appendChild(itemHTML);
        });
    }

    if (checkoutWhatsapp) {
        const message = createWhatsappMessage(total);
        checkoutWhatsapp.href = "https://wa.me/50688857768?text=" + encodeURIComponent(message);
    }
}

// Genera el texto dinámico para enviar el pedido por WhatsApp
function createWhatsappMessage(total) {
    if (cart.length === 0) {
        return "Hola Destellos, quiero información sobre sus joyas.";
    }

    let message = "Hola Destellos, quiero comprar estos productos:\n\n";

    cart.forEach(item => {
        message += `- ${item.name} x${item.quantity} = ${formatMoney(item.price * item.quantity)}\n`;
    });

    message += `\nTotal: ${formatMoney(total)}`;

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

// Abre el panel lateral del carrito
function openCart() {
    const cartPanel = document.getElementById("cart-panel");
    const cartOverlay = document.getElementById("cart-overlay");

    if (cartPanel) {
        cartPanel.classList.add("active");
    }

    if (cartOverlay) {
        cartOverlay.classList.add("active");
    }
}

// Alterna la visibilidad del carrito (abrir/cerrar)
function toggleCart() {
    const cartPanel = document.getElementById("cart-panel");
    const cartOverlay = document.getElementById("cart-overlay");

    if (cartPanel) {
        cartPanel.classList.toggle("active");
    }

    if (cartOverlay) {
        cartOverlay.classList.toggle("active");
    }
}

// Asegura que la UI esté actualizada al cargar la página
document.addEventListener("DOMContentLoaded", updateCart);
