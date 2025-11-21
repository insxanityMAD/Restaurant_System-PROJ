<?php
session_start();

// Database connection
$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";

$conn = mysqli_connect($server, $user, $pass, $db_name);
if (!$conn) {
    die("Database connection error");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    background-image: url("images/v602-nunoon-40-rippednotes.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    font-family: Arial;
}

.container {
    display: flex;
    flex-direction: column;
    padding: 10px;
}

.box2 {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.dish {
    width: 280px;
    background: #eadabf;
    border: 2px solid #f3e0a8;
    border-radius: 12px;
    padding: 10px;
    transition: 0.3s ease;
}

.dish:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.sud-an {
    background: linear-gradient(180deg, #ffbf4d, #ff9b00);
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 20px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 18px;
}

.dish p {
    font-size: 15px;
    margin-top: 5px;
    text-align: center;
}

.qty-controls {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 10px;
}

.qty-controls button {
    width: 45px;
    height: 45px;
    font-size: 24px;
    font-weight: bold;
    border-radius: 10px;
    border: 2px solid #444;
    background: #ffebc1;
    cursor: pointer;
}

.qty-num {
    font-size: 22px;
    font-weight: bold;
    width: 40px;
    text-align: center;
}

.box3 {
    width: 100%;
    max-width: 500px;
    align-self: center;
    margin-top: 20px;
    padding: 20px;
    border-radius: 14px;
    background: rgba(18, 18, 18, 0.6);
    color: white;
    box-shadow: 0 18px 40px rgba(0,0,0,0.4);
}

.totals div {
    font-size: 20px;
}

#totalPrice {
    font-size: 22px;
}

.checkout {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}

.checkout button {
    font-size: 20px;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
}

#clearBtn {
    background: transparent;
    color: white;
    border: 1px solid rgba(255,255,255,.3);
}

#orderBtn {
    background: #ffae00;
    color: white;
}

/* Responsive */
@media (max-width: 600px) {
    .dish { width: 90%; }
}
</style>
</head>
<body>

<div class="container">

    <div class="box2" id="menu">
        <?php
        $sql = "SELECT * FROM menu_tbl";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dishId = $row['dish_id'];
                $dishName = $row['Dish_Info'];
                $dishPrice = number_format($row['Price'], 2);
                $dishType = $row['Food_Type'];
                $imagePath = !empty($row['image']) ? "uploads/" . $row['image'] : "uploads/noimage.png";

                echo "
                <div class='dish' data-id='{$dishId}' data-price='{$row['Price']}'>
                    <img src='{$imagePath}' alt='{$dishName}'
                        style='width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto 12px auto; border-radius: 15px;'>

                    <div>
                        <div class='sud-an'>
                            {$dishName}
                            <div class='price'>₱{$dishPrice}</div>
                        </div>
                        <p>{$dishType}</p>
                    </div>

                    <div class='qty-controls'>
                        <button class='qty-decrease'>−</button>
                        <div class='qty-num'>0</div>
                        <button class='qty-increase'>+</button>
                    </div>
                </div>
                ";
            }
        }
        ?>
    </div>

    <div class="box3">
        <div class="totals">
            <div>Total items: <span id="totalQty">0</span></div>
            <div>Total price: <strong id="totalPrice">₱0.00</strong></div>
        </div>

        <div class="checkout">
            <button id="clearBtn" type="button">Clear</button>
            <button id="orderBtn" type="button">Place Order</button>
        </div>
    </div>
</div>

<script>
const formatCurrency = (num) => '₱' + Number(num || 0).toFixed(2);

const menuEl = document.getElementById('menu');
const totalQtyEl = document.getElementById('totalQty');
const totalPriceEl = document.getElementById('totalPrice');
const clearBtn = document.getElementById('clearBtn');
const orderBtn = document.getElementById('orderBtn');

const dishes = Array.from(menuEl.querySelectorAll('.dish')).map(dishEl => {
    const id = dishEl.dataset.id;
    const price = parseFloat(dishEl.dataset.price) || 0;
    const qtyEl = dishEl.querySelector('.qty-num');
    const name = dishEl.querySelector('.sud-an').innerText.split('\n')[0].trim();

    return { id, name, price, el: dishEl, qtyEl, qty: 0 };
});

function saveCart() {
    const payload = dishes
        .filter(d => d.qty > 0)
        .map(d => ({ id: d.id, name: d.name, price: d.price, qty: d.qty }));

    localStorage.setItem('cart', JSON.stringify(payload));
}

function loadCart() {
    try {
        const saved = JSON.parse(localStorage.getItem('cart') || '[]');
        saved.forEach(item => {
            const dish = dishes.find(d => d.id === String(item.id));
            if (dish) setDishQty(dish, item.qty);
        });
    } catch {}
}

function updateTotals() {
    let totalQty = 0;
    let totalPrice = 0;

    dishes.forEach(d => {
        totalQty += d.qty;
        totalPrice += d.qty * d.price;
    });

    totalQtyEl.textContent = totalQty;
    totalPriceEl.textContent = formatCurrency(totalPrice);

    saveCart();
}

function setDishQty(dish, newQty) {
    dish.qty = Math.max(0, Math.floor(newQty));
    dish.qtyEl.textContent = dish.qty;
    updateTotals();
}

dishes.forEach(dish => {
    dish.el.querySelector('.qty-increase')
        .addEventListener('click', () => setDishQty(dish, dish.qty + 1));

    dish.el.querySelector('.qty-decrease')
        .addEventListener('click', () => setDishQty(dish, dish.qty - 1));
});

clearBtn.addEventListener('click', () => {
    dishes.forEach(d => setDishQty(d, 0));
    localStorage.removeItem('cart');
});

orderBtn.addEventListener('click', () => {
    const items = dishes.filter(d => d.qty > 0);
    if (items.length === 0) {
        alert('Your cart is empty.');
        return;
    }

    saveCart();
    window.location.href = "order1.php";
});

loadCart();
updateTotals();
</script>

</body>
</html>
