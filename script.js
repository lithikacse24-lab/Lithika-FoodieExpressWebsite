let cart = [];
let total = 0;

function increaseQty(id) {
    let qty = document.getElementById(id);
    qty.value = parseInt(qty.value) + 1;
}

function decreaseQty(id) {
    let qty = document.getElementById(id);

    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}

function addToCart(name, price, qtyId) {

    let qty = parseInt(
        document.getElementById(qtyId).value
    );

    let itemTotal = price * qty;

    cart.push({
        name: name,
        qty: qty,
        price: itemTotal
    });

    total += itemTotal;

    displayCart();
}

function displayCart() {

    let list =
        document.getElementById("cartList");

    list.innerHTML = "";

    cart.forEach(item => {

        list.innerHTML += `
        <li>
            ${item.name}
            x ${item.qty}
            = ₹${item.price}
        </li>
        `;

    });

    document.getElementById("total")
        .innerText = total;
}

function placeOrder() {

    let customerName =
        document.getElementById("customerName")
            .value;

    if (customerName.trim() === "") {

        alert("Please enter customer name");

        return;
    }

    if (cart.length === 0) {

        alert("Cart is empty");

        return;
    }

    fetch("place_order.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({

            customer_name: customerName,

            items: cart,

            total_price: total

        })

    })

        .then(response => response.json())

        .then(data => {

            document.getElementById("message")
                .innerHTML = data.message;

            cart = [];
            total = 0;

            displayCart();

            document.getElementById("customerName")
                .value = "";

        })

        .catch(error => {

            console.error(error);

        });
}

function searchFood() {

    let search =
        document.getElementById("search")
            .value
            .toLowerCase();

    let cards =
        document.querySelectorAll(".card");

    cards.forEach(card => {

        let foodName =
            card.querySelector("h3")
                .innerText
                .toLowerCase();

        if (foodName.includes(search)) {

            card.style.display = "block";

        } else {

            card.style.display = "none";

        }

    });
}

function toggleDarkMode() {

    document.body.classList.toggle("dark");

}